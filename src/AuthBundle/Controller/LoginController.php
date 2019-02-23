<?php

namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    public function indexAction(Request $request)
    {
        /**
         * @var \Symfony\Component\Security\Http\Authentication\AuthenticationUtils $helper
         */
        $helper = $this->get('security.authentication_utils');
        return $this->render('@Auth/Login/index.html.twig',array(
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError()
        ));
    }

    public function checkAction()
    {

    }
}
