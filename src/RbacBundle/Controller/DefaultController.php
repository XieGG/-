<?php
namespace RbacBundle\Controller;

use BaseBundle\Controller\BaseController;
use RbacBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use RbacBundle\Form\Type\UserType;
use UserBundle\Entity\WebUser;

class DefaultController extends BaseController
{

    public function personalData(Request $request)
    {
        // $user = $this->getUser();
        return $this->render('@Rbac/Default/personal_data.html.twig');
    }

    public function indexAction(Request $request)
    {
        // 分页处理
        $dql = "SELECT u FROM RbacBundle:User u ORDER BY u.cREATEAT DESC";
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('@Rbac/Default/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * new user
     *
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $errors = [];
        $user = null;
        $em = $this->getDoctrine()->getManager();
        // 获取角色组
        $roles = $em->getRepository('RbacBundle:Role')->findAll();
        // 表单提交
        if ($request->request->get('submit')) {
//            dump($request->request->get('user'));die;
            $user = $this->handleRequest($request, '\RbacBundle\Entity\User', 'user');
            if (! empty($user->getPASSWORD())) {
                $salt = uniqid();
                $user->setSalt($salt);
                /**
                 *
                 * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder $encoder
                 */
                $encoder = $this->get('security.password_encoder');
                $password = $encoder->encodePassword($user, $user->getPASSWORD());
                $user->setPASSWORD($password);
            }

            $role = $em->getRepository('RbacBundle:Role')->find($user->getROLEID());
            if (empty($role)) {
                return $this->msgResponse(2, '错误', '未找到角色组信息', 'rbac_user_new');
            }
            $user->setGROUP($role);
            $user->setROLE('ROLE_ADMIN');
            $user->setIP($request->getClientIp());
            if ($request->request->get('user')['lEVEL']=='2'){
                if(!empty($request->request->get('user')['city'])){
                    $user->setCITY(implode(',', $request->request->get('user')['city']));
                }
            }
            if ($request->request->get('user')['lEVEL']=='3'){
                $user->setCITY($request->request->get('user')['citys']);
            }
            if ($request->request->get('user')['lEVEL']=='4'){
                $user->setCITY($request->request->get('user')['citys']);
                $user->setArea($request->request->get('user')['areas']);
            }

            // 验证数据
            $validator = $this->get('validator');
            $errors = $validator->validate($user);
            if (count($errors) == 0) {
                $em->persist($user);
                $em->flush();
                return $this->msgResponse(0, '成功', '添加用户成功', 'rbac_user');
            }
        }
        $cities = $em->getRepository('OrganBundle:Area')->findBy([
            'level' => 2
        ]);
        return $this->render('@Rbac/Default/new.html.twig', [
            'errors' => $errors,
            'cities' => $cities,
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function webUserAction(Request $request)
    {
        $id = $request->query->get('id');
        $user = $this->getDoctrine()
            ->getRepository('RbacBundle:User')
            ->find($id);
        $webUser = new WebUser();
        $webUser->setUsername($user->getUsername());
        $webUser->setSalt($user->getSALT());
        $webUser->setMobile($user->getUSERNAME());
        $webUser->setTruename($user->getXM());
        $webUser->setPassword($user->getPASSWORD());
        $webUser->setRole($user->getROLE());
        $webUser->setUserType();
        
        dump($user, $webUser);
        exit();
    }

    /**
     * edit user
     *
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $errors = [];
        $id = $request->query->get('id');
        /**
         *
         * @var \RbacBundle\Entity\User $urepo
         */
        $urepo =  $this->getDoctrine()->getRepository('RbacBundle:User');
        $user =$urepo ->find($id);
        $em = $this->getDoctrine()->getManager();
        // 获取角色组
        $roles = $em->getRepository('RbacBundle:Role')->findAll();
        // 表单提交
        if ($request->request->get('submit')) {
//            dump($request->request->get('user'));die;
//            $user = $this->handleRequest($request, '\RbacBundle\Entity\User', 'user');
            if (! empty($request->request->get('user')['pASSWORD'])) {
                $salt = uniqid();
                $user->setSalt($salt);
                /**
                 *
                 * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoder $encoder
                 */
                $encoder = $this->get('security.password_encoder');
                $password = $encoder->encodePassword($user, $request->request->get('user')['pASSWORD']);
                $user->setPASSWORD($password);
            }
            $user->setUSERNAME($request->request->get('user')['uSERNAME']);
            $role = $em->getRepository('RbacBundle:Role')->find($user->getROLEID());
            if (empty($role)) {
                return $this->msgResponse(2, '错误', '未找到角色组信息', 'rbac_user_new');
            }
            $user->setGROUP($role);
            $user->setROLE('ROLE_ADMIN');
            $user->setIP($request->getClientIp());
            $user->setXM($request->request->get('user')['xM']);
            $user->setLEVEL($request->request->get('user')['lEVEL']);
            if ($request->request->get('user')['lEVEL']=='2'){
                if(!empty($request->request->get('user')['city'])){
                    $user->setCITY(implode(',', $request->request->get('user')['city']));
                }
            }
            if ($request->request->get('user')['lEVEL']=='3'){
                $user->setCITY($request->request->get('user')['citys']);
                $user->setArea('');
            }
            if ($request->request->get('user')['lEVEL']=='4'){
                $user->setCITY($request->request->get('user')['citys']);
                $user->setArea($request->request->get('user')['areas']);
            }

            // 验证数据
            $validator = $this->get('validator');
            $errors = $validator->validate($user);
            if (count($errors) == 0) {
                $em->persist($user);
                $em->flush();
                return $this->msgResponse(0, '成功', '编辑用户成功', 'rbac_user');
            }
        }
        $cities = $em->getRepository('OrganBundle:Area')->findBy([
            'level' => 2
        ]);
        return $this->render('@Rbac/Default/edit.html.twig', [
            'errors' => $errors,
            'cities' => $cities,
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function showAction(Request $request)
    {
        $id = $request->query->getInt('id');
        $user = $this->getDoctrine()
            ->getRepository('RbacBundle:User')
            ->find($id);
        return $this->render('RbacBundle:Default:show.html.twig', [
            'user' => $user
        ]);
    }

    public function deleteAction(Request $request)
    {
        $id = $request->request->getInt('id');
        $item = $this->getDoctrine()
            ->getRepository('RbacBundle:User')
            ->find($id);
        if (! $item) {
            return new JsonResponse([
                'status' => 0,
                'msg' => '记录不存在'
            ]);
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
            return new JsonResponse([
                'status' => 1,
                'msg' => '删除成功'
            ]);
        }
    }
}
