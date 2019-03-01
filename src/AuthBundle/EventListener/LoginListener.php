<?php
namespace AuthBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use RbacBundle\Entity\User;

class LoginListener
{
    private $session;
    private $em;
    
    public function __construct(Session $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }
    
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        /**
         * @var \RbacBundle\Entity\User $user
         */
        $user = $event->getAuthenticationToken()->getUser();
        if($user instanceof User){
            /**
             *
             * @var \RbacBundle\Entity\Role $goup
             */
            $group = $user->getGroup();
            $menu = $this->em->getRepository('SystemBundle:Menu')->getMenuByRole($group->getId(), $group->getNodes(), $group->getLevel());
            $this->session->set('menu', $menu);
        }
    }
}