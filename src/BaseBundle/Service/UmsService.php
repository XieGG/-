<?php
namespace BaseBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class UmsService
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
     * 发起请求
     */
    public function request($mobile, $type = '')
    {
        $client = $this->getClient();
        try {
            $code = substr(str_shuffle('1234567890'), 0, 4);
            if (false === $params = $this->getRequestParam($mobile, $type, $code)) {
                return [
                    'code' => 8,
                    'msg' => 'faild 参数有误',
                    'data' => ''
                ];
            }
            $response = $client->post($params['uri'], [
                'form_params' => $params['data'],
            ]);
            if (200 == $response->getStatusCode()) {
                $content = (string) $response->getBody();
                $content = mb_convert_encoding($content, "UTF-8", "GBK");
                $output = '';
                parse_str($content, $output);
                if(isset($output['result']) && isset($output['description'])){
                    if(0 == $output['result']){
                        return [
                            'code' => 1,
                            'msg' => '发送成功',
                            'data' => $code
                        ];
                    }else{
                        return [
                            'code' => 2,
                            'msg' => '发送失败',
                            'data' => $output
                        ];
                    }
                }
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
        return $this->container->get('guzzle.client.api_ums');
    }

    private function getRequestParam($mobile, $type, $code = "")
    {
        switch ($type) {
            case 'register':
            case 'forget':
            case 'sms':
            default:
                $msg = '您的短信验证码为' . $code . '有效时间为10分钟,请保管好您的验证码,不要泄露信息。';
                break;
        }

        return [
            'uri' => '/sms/Api/Send.do',
            'data' => [
                'SpCode' => '244765',
                'LoginName' => 'admin0',
                'Password' => 'sft2681081.',
                'MessageContent' => mb_convert_encoding($msg, "GBK", "UTF-8"),
                'UserNumber' => $mobile,
                'SerialNumber' => time() . substr($mobile, 1),
                'f' => 1
            ]
        ];
    }
}