<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Linfo\Linfo;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $linfo = new \Linfo\Linfo();
        $parser = $linfo->getParser();
        dump($parser->getRam());die;
        return $this->render('@Admin/Default/index.html.twig');
    }
}
