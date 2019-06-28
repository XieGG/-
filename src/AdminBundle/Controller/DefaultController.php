<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Linfo\Linfo;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /*
         * 先注释掉了. 在linux上在放开. win下开发禁止使用Linfo。
         */
//        $linfo = new \Linfo\Linfo();
//        $parser = $linfo->getParser();
//        dump($parser->getRam());
        return $this->render('@Admin/Default/index.html.twig');
    }
}
