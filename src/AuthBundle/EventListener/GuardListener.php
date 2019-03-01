<?php
namespace AuthBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\Container;
use SystemBundle\Entity\SystemLog;
use RbacBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GuardListener
{
    private $router;
    private $container;

    public function __construct($router, Container $container)
    {
        $this->router = $router;
        $this->container = $container;
    }
    /**
     * 路由白名单
     */
    private function whiteList()
    {
        return [
            'auth_homepage',
            'auth_default_deny',
            'auth_login_index',
            'auth_login_check',
            'auth_login_logout',
            'admin_homepage',
            'base_getinformation_searchJGBM',
            'base_getinformation_getArea',
            'base_uploadFile',
            'api_homepage',
            'lbs_positioninghistory_gethistoryajax',
            'lbs_homepage_relationpersonnel',
            'book_get_correct_ajax',
            'book_periodicreport_jzry_select'
        ];
    }
    /**
     * 校验是否在白名单
     */
    private function checkWhite($route)
    {
        if(in_array($route, $this->whiteList())){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 校验路由是否允许访问
     *
     * @param unknown $route
     */
    private function checkRoute(Request $request, $route)
    {
        $menu = $request->getSession()->get('menu');
        if(empty($menu) || !isset($menu['access_list'])) return false;
        if(in_array($route, $menu['access_list'])){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 访问路由非法时，重定向
     *
     * @param GetResponseEvent $event
     */
    private function denyResponse(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if($request->isXmlHttpRequest()){
            $response = new JsonResponse([
                'code' => 403,
                'msg' => '无权限访问',
            ]);
        }else{
            $response = new RedirectResponse($this->router->generate('auth_default_deny'));
        }
        //  发送修改后的响应对象到事件中
        $event->setResponse($response);
    }
    /**
     *
     * @param unknown $_route
     * @return boolean
     */
    private function notSaveParam($_route)
    {
        return in_array($_route, [
            'auth_login_check'
        ]);
    }
    /**
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        return true;
        if (!$event->isMasterRequest()) {
            return;
        }
       $request = $event->getRequest();

       // Matched route
       $_route  = $request->attributes->get('_route');
       $post = $request->request->all();
       $get = $request->query->all();
       if($this->notSaveParam($_route)){
           $post = [];
       }
       /**
        *
        * @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine
        */
       $doctrine = $this->container->get('doctrine');
        /**
         * @var $em \Doctrine\ORM\EntityManager
         */
       $em = $doctrine->getManager();
       if (null === $token = $this->container->get('security.token_storage')->getToken()) {
           return;
       }
       /**
        * @var $user \RbacBundle\Entity\User
        */
       $user = $token->getUser();
       if($user instanceof User){
           $userId = $user->getId();
           $username = $user->getUsername();
           // 校验路由是否允许
           /**
            *
            * @var \Symfony\Bridge\Monolog\Logger $logger
            */
           $logger = $this->container->get('logger');
           $logger->addEmergency($_route);
           if(!empty($_route) && false === $this->checkWhite($_route) && false === $this->checkRoute($request, $_route)){
               $this->denyResponse($event);
           }
       }else{
           $userId = 0;
           $username = '游客';
       }
       $menu = $doctrine->getRepository('SystemBundle:Menu')->findOneBy([
           'englishName' => $_route
       ]);
       if(empty($menu)){
           $routeName = '未知路由';
       }else{
           $routeName = $menu->getName();
       }
       $systemLog = new SystemLog();
       $systemLog->setAdminId($userId);
       $systemLog->setUsername($username);
       $systemLog->setRoute($_route);
       $systemLog->setRouteName($routeName);
       $systemLog->setUri($request->getUri());
       $systemLog->setGetParameter(json_encode($get));
       $systemLog->setPostParameter(json_encode($post));
       $systemLog->setIp($request->getClientIp());
       $systemLog->setCreateAt(new \DateTime());
       $em->persist($systemLog);
       $em->flush();
    }
}