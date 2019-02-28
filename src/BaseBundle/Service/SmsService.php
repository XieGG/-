<?php
namespace BaseBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use MessageBundle\Entity\MsmSending;

class SmsService
{

    private $em;

    private $container;

    /**
     *
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;

    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }

    /**
     *
     * @param string $mobile
     * @param string $ip
     * @return boolean
     */
    public function addSms($mobile, $ip = '', $content = '', $fSR, $signature)
    {
        $mobile = is_array($mobile) ? implode(',', $mobile) : $mobile;
        if (false !== strpos($mobile, ',')) {
            $saveData = $this->saveData($mobile, $ip, $content, $fSR, $signature);
            if (false == $saveData)
                return false;
            return $saveData;
        } else {
            if (false === $content)
                return false;
            $MsmSending = new MsmSending();
            $MsmSending->setDHHM($mobile);
            $MsmSending->setDXNR($signature . $content);
            $MsmSending->setIP($ip);
            $MsmSending->setFSZT('1');
            $MsmSending->setFSR($fSR);
            $this->em->persist($MsmSending);
            $this->em->flush();
            return true;
        }
    }

    private function saveData($mobile, $ip, $content = '', $fSR, $signature)
    {
        if (false === $content)
            return false;
        $mobile = explode(',', $mobile);
        foreach ($mobile as $vo) {
            $MsmSending = new MsmSending();
            $MsmSending->setDHHM($vo);
            $MsmSending->setDXNR($signature . $content);
            $MsmSending->setIP($ip);
            $MsmSending->setFSZT('1');
            $MsmSending->setFSR($fSR);
            $this->em->persist($MsmSending);
        }
        $this->em->flush();
        return true;
    }

    /**
     *
     * @return unknown[]|number[]
     */
    public function sendSms()
    {
        // 获取最新的20条记录
        $list = $this->em->getRepository('MessageBundle:MsmSending')->findBy([
            'fSZT' => 0
        ], [
            'id' => 'ASC'
        ], 20);
        $success = $faild = 0;
        /**
         *
         * @var \MessageBundle\Entity\MsmSending $val
         */
        foreach ($list as $val) {
            $response = $this->request(0, $val, 0, 0);
            if (1 == $response['code']) {
                $val->setFSZT(1);
                $success ++;
            } else {
                $val->setFSZT(2);
                $faild ++;
            }
            $val->setResponse(json_encode($response['data']));
            $this->em->persist($val);
            $this->em->flush();
            sleep(1);
        }
        return [
            'success' => $success,
            'faild' => $faild
        ];
    }

    /**
     * 发起请求
     */
    public function request($mobile, $sms = '', $dXNR = '', $type = '')
    {
        $client = $this->getClient();
        try {
            if ($sms instanceof MsmSending) {
                $params = $this->getParams($sms);
            } else {
                if (false !== $params = $this->getRequestParam($mobile, $dXNR, $type)) {
                    $params = $this->getRequestParam($mobile, $dXNR, $type);
                } else {
                    return [
                        'code' => 8,
                        'msg' => 'faild 参数有误',
                        'data' => ''
                    ];
                }
            }
            $response = $client->post($params['uri'], [
                'form_params' => $params['data']
            ]);
            if (200 == $response->getStatusCode()) {
                $content = (string) $response->getBody();
                if (false !== strpos($content, ',')) {
                    $result = explode(',', $content);
                    if ('03' == $result[0] || '00' == $result[0]) {
                        return [
                            'code' => 1,
                            'msg' => 'success',
                            'data' => ''
                        ];
                    } else {
                        return [
                            'code' => 2,
                            'msg' => 'faild',
                            'data' => $content
                        ];
                    }
                } else {
                    switch (intval($content)) {
                        case '2':
                            $content=$content.'IP限制';
                            break;
                        case '4':
                            $content=$content.'用户名错误';
                            break;
                        case '5':
                            $content=$content.'密码错误';
                            break;
                        case '7':
                            $content=$content.'发送时间有误';
                            break;
                        case '8':
                            $content=$content.'内容有误';
                            break;
                        case '9':
                            $content=$content.'手机号码有误';
                            break;
                        case '10':
                            $content=$content.'扩展号码有误';
                            break;
                        case '11':
                            $content=$content.'余额不足';
                            break;
                        default:
                            $content=$content.'服务器内部异常';
                    }
                    return [
                        'code' => 3,
                        'msg' => 'response error',
                        'data' => $content
                    ];
                }
                return $content;
            } else {
                return [
                    'code' => 4,
                    'msg' => 'http error',
                    'data' => [
                        'exception_code' => $response->getStatusCode(),
                        'exception_msg' => 'http code',
                        'request' => '',
                        'response' => $response->getBody()->getContents()
                    ]
                ];
            }
        } catch (ClientException $e) {
            return [
                'code' => 5,
                'msg' => 'clint exception',
                'data' => [
                    'exception_code' => $e->getCode(),
                    'exception_msg' => $e->getMessage(),
                    'request' => $e->getRequest(),
                    'response' => $e->getResponse()
                ]
            ];
        } catch (RequestException $e) {
            return [
                'code' => 6,
                'msg' => 'request exception',
                'data' => [
                    'exception_code' => $e->getCode(),
                    'exception_msg' => $e->getMessage(),
                    'request' => $e->getRequest(),
                    'response' => $e->getResponse()
                ]
            ];
        } catch (\Exception $e) {
            return [
                'code' => 7,
                'msg' => 'exception',
                'data' => [
                    'exception_code' => $e->getCode(),
                    'exception_msg' => $e->getMessage(),
                    'request' => $e->getFile(),
                    'response' => $e->getLine()
                ]
            ];
        }
    }

    /**
     * get guzzle http client
     *
     * @return \GuzzleHttp\Client
     */
    private function getClient()
    {
        return $this->container->get('guzzle.client.api_sms');
    }

    private function getRequestParam($mobile, $dXNR = '', $type, $code = "")
    {
        switch ($type) {
            case 'register':
                $msg = '【山西司法12348系统】欢迎注册山西司法社区矫正系统系统，验证码:' . $code . '';
                break;
            case 'forget':
                $msg = '【山西司法12348系统】您正在找回密码，验证码:' . $code . '';
                break;
            case 'sms':
                $msg = "【山西司法12348系统】通知您:";
                break;
            default:
                return false;
                break;
        }

        return [
            'uri' => '/SendMT/SendMessage',
            'data' => [
                'CorpID' => 'jicheng',
                'Pwd' => 'hcelbe',
                'Mobile' => is_array($mobile) ? implode(',', $mobile) : $mobile,
                'Content' => $msg . $dXNR
            ]
        ];
    }

    private function getParams(MsmSending $sms)
    {
        return [
            'uri' => '/SendMT/SendMessage',
            'data' => [
                'CorpID' => 'jicheng',
                'Pwd' => 'hcelbe',
                'Mobile' => $sms->getDHHM(),
                'Content' => $sms->getDXNR()
            ]
        ];
    }
}