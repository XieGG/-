<?php

namespace SystemBundle\Controller;

use BaseBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

class WebInfoController extends BaseController
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $webInfo = $em->getRepository('SystemBundle:WebInfo')->getAll();
        //表单提交
        if($request->getMethod() == 'POST'){
            $webtitle = $request->request->get('title');

        }
        return $this->render('@System/Default/index.html.twig',[
            'webinfo' => $webInfo
        ]);
    }
}
