<?php
namespace BaseBundle\Service;

class Base64Service
{
    private $rootDir;
    
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }
    /**
     * 附件数据上传时，文件内容转为base64
     * 
     * @param unknown $path
     */
    public function fileToBase64($path)
    {
        return base64_encode(file_get_contents($this->rootDir . '/../web/'. trim($path, '/')));
    }
}