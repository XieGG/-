<?php
namespace BaseBundle\Service;

use Gregwar\Image\Image;
use Gregwar\ImageBundle\Services\ImageHandling;

class ImageService
{
    private $appRoot;
    private $handling;
    
    public function __construct($appRoot, ImageHandling $handling)
    {
        $this->appRoot = $appRoot;
        $this->handling = $handling;
    }
    
    /**
     * 打水印，并生成缩略图
     * @param unknown $address
     * @param string $thumb 默认为false，不生成缩略图
     */
    public function run($filePath, $address, $thumb = false)
    {
        try {
            $fullPath = $this->appRoot . '/../web/' . $filePath;
            $font = $this->appRoot . '/../web/public/fonts/yahei.ttf';
            $image = $this->handling->open($fullPath);
            $width = $image->width();
            $height = $image->height();
            $rate = $width/500;
            $image->write($font, $address, $width - 10 * $rate, 20 * $rate, 12 * $rate, 0, 0xff0000, 'right');
            $image->write($font, date('Y-m-d H:i:s'), $width - 10 * $rate, $height - 20 * $rate, 12  * $rate, 0, 0xff0000, 'right');
            file_put_contents($fullPath . '.jpeg', $image->get('jpeg', 100));
            if($thumb){
                file_put_contents($fullPath.'.jpeg.min.png', $image->cropResize(90, 90, '0xffffff')->get('png'));
            }
            return [
                'code' => 1,
                'msg' => 'success',
                
            ];
        }catch (\Exception $e) {
            return [
                'code' => 0,
                'msg' => $e->getCode() . ':' . $e->getMessage()
            ];
        }
    }
}