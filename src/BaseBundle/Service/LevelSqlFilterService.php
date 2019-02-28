<?php
namespace BaseBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use RbacBundle\Entity\User;

class LevelSqlFilterService
{
    private $container;
    /**
     *
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->doctrine = $this->container->get('doctrine');
    }
    /**
     * enable sql filter
     *
     * @param unknown $current
     */
    public function enableFilter($em, User $user)
    {
        $level = $user->getLevel();
        switch ($level) {
            case 0:
                // 系统管理员
            case 1:
                //厅级管理员
                break;
            case 2:
                //市级
                $filters = $em->getFilters()->enable('base.level_filter');
                $filters->setParameter('filedName', 'jZJGSZDSSFJ');
                $filters->setParameter('filedValue', $user->getJZJGSZDSSFJ());
                break;
            case 3:
                //县区级
                $filters = $em->getFilters()->enable('base.level_filter');
                $filters->setParameter('filedName', 'jZJGSZQXSFJ');
                $filters->setParameter('filedValue', $user->getJZJGSZQXSFJ());
                break;
            case 4:
                //司法所级
                $filters = $em->getFilters()->enable('base.level_filter');
                $filters->setParameter('filedName', 'jZJGSZSFS');
                $filters->setParameter('filedValue', $user->getJZJGSZSFS());
                break;
            default:
                return false;
                break;
        }
        return true;
    }
}