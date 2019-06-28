<?php
namespace BaseBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file,$DirName)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDir."/{$DirName}",$fileName);
        return '/uploads/'.$DirName.'/'.$fileName;
    }
}