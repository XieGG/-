<?php
namespace RbacBundle\Service;

use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Bridge\Monolog\Logger;

class LogoutHandler implements LogoutHandlerInterface
{
    private $logger;
    
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Symfony\Component\Security\Http\Logout\LogoutHandlerInterface::logout()
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        // TODO: Auto-generated method stub
        $userId = $token->getUser()->getId();
        $this->logger->alert('user id' . $userId . ' logout');
        $request->getSession()->clear();
        return $response;
    }
}