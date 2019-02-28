<?php
namespace BaseBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use RbacBundle\Entity\User;

class EnableFilterListener
{
    protected $em;
    protected $tokenStorage;
    protected $reader;
    
    public function __construct(EntityManager $em, TokenStorageInterface $tokenStorage)
    {
        $this->em              = $em;
        $this->tokenStorage    = $tokenStorage;
    }
    
    public function onKernelRequest()
    {
        $token = $this->tokenStorage->getToken();
        
        if (!$token) {
            return false;
        }
        $user = $token->getUser();
        if ($user instanceof User) {
            $level = $user->getLEVEL();
            switch ($level) {
                case 0:
                    // 系统管理员
                case 1:
                    //厅级管理员
                    break;
                case 2:
                    //市级
//                    $filters = $this->em->getFilters()->enable('base.level_filter');
//                    $filters->setParameter('filedName', 'jZJGSZDSSFJ');
//                    $filters->setParameter('filedValue', $user->getJZJGSZDSSFJ());
                    break;
                case 3:
                    //县区级
//                    $filters = $this->em->getFilters()->enable('base.level_filter');
//                    $filters->setParameter('filedName', 'jZJGSZQXSFJ');
//                    $filters->setParameter('filedValue', $user->getJZJGSZQXSFJ());
                    break;
                case 4:
                    //司法所级
//                    $filters = $this->em->getFilters()->enable('base.level_filter');
//                    $filters->setParameter('filedName', 'jZJGSZSFS');
//                    $filters->setParameter('filedValue', $user->getJZJGSZSFS());
                    break;
                default:
                    return false;
                    break;
            }
        }else{
            return false;
        }
        return true;
    }
}