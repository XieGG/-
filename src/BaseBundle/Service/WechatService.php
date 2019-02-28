<?php
namespace BaseBundle\Service;

use EasyWeChat\Factory;

/**
 *
 * @name 微信公众号service
 * @author yanfeng1012
 * @copyright sxjicheng.com
 * @var 2019-02-10 15:48:00
 */
class WechatService
{

    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
        $this->factory = new Factory();
    }

    /**
     *
     * @name 配置并获取
     * @return \EasyWeChat\BasicService
     */
    public function config()
    {
        $options = [
            'app_id' => 'wxb510f1f79185f948',
            'secret' => '27958fec34f7ad4ebe470388e5ac8a9d',
            'token' => 'lawwechat',
            'aes_key' => 'uhY6sX5iWKiIC2h8f2yAZuyqtqqKQNKJEcGtGLoEU1M'
        ];
        $app = $this->factory::officialAccount($options);
        return $app;
    }

    /**
     *
     * @name 生成场景二维码
     * @param string $sceneId
     */
    public function generateQRcode($sceneId)
    {
        $app = $this->config();

        $result = $app->qrcode->temporary($sceneId, 2 * 3600);

        $url = $app->qrcode->url($result['ticket']);
        $content = file_get_contents($url);

        $byte = file_put_contents($this->dir . '/qr/qr_' . $sceneId . '.jpg', $content);
        if ($byte) {
            return '/uploads/qr/qr_' . $sceneId . '.jpg';
        } else {
            return false;
        }
    }

    /**
     *
     * @name 获取AccessToken
     */
    private function getAccessToken()
    {
        $app = $this->config();
        // 获取 access token 实例
        $accessToken = $app->access_token;
        $token = [];
        $token = $accessToken->getToken(true); // token 数组 token['access_token'] 字符串
        return $token['access_token'];
    }
}
