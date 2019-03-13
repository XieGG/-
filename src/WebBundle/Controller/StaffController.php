<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StaffController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Web/Staff/index.html.twig');
    }
}
