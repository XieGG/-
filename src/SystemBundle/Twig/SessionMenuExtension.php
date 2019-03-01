<?php
namespace SystemBundle\Twig;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;

class SessionMenuExtension extends \Twig_Extension
{
    private $session;
    private $em;
    
    public function __construct(Session $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }
    
    
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('session_menu_list', array($this, 'menulist')),
            new \Twig_SimpleFunction('session_menu_in', array($this, 'in')),
            new \Twig_SimpleFunction('session_menu_sidebar', array($this, 'sidebar')),
        );
    }
    
    public function menulist()
    {
        $menu = $this->getMenu();
        return isset($menu['parent']) ? $menu['parent'] : [];
    }

    public function in($node, $route)
    {
        $menu = $this->getMenu();
        return in_array($route, (isset($menu['list'][$node]) ? $menu['list'][$node] : []));
    }
    public function sidebar($parentRoute)
    {
        $menu = $this->getMenu();
        return isset($menu['child'][$parentRoute]) ? $menu['child'][$parentRoute] : [];
    }
    
    private function getMenu()
    {
        return $this->session->get('menu');
    }
}