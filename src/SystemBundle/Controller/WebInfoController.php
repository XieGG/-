<?php

namespace SystemBundle\Controller;

use BaseBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use SystemBundle\Entity\WebInfo;

class WebInfoController extends BaseController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $webInfo = $em->getRepository('SystemBundle:WebInfo');
        $webInfoResult = $webInfo->getFindInfo();
        if(empty($webInfoResult)){
            $webInfoResult = new WebInfo();
        }
        //表单提交
        if($request->getMethod() == 'POST'){
            $webtitle = $request->request->get('title');
            $logoImg = $request->files->get('file');
            if(!empty($logoImg)){
                $fileUrl = $this->formUploadFile($logoImg,['image/jpeg'],1000000,'img');
                $webInfoResult->setLogo($fileUrl);
            }
            $webInfoResult->setTitle($webtitle);
            $em->persist($webInfoResult);
            $em->flush();
        }
        return $this->render('@System/Default/index.html.twig',[
            'webinfo' => $webInfoResult
        ]);
    }
}
