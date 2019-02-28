<?php
namespace RbacBundle\Controller;

use BaseBundle\Controller\BaseController;
use RbacBundle\Entity\Role;
use Symfony\Component\HttpFoundation\Request;
use RbacBundle\Form\Type\RoleType;

class RoleController extends BaseController
{

    /**
     * 角色组列表
     * 
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // 分页处理
        $dql = "SELECT r FROM RbacBundle:Role r ORDER BY r.createAt DESC";
        
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        
        return $this->render('@Rbac/Role/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * 权限设置
     * 
     * @param Request $request            
     */
    public function setAction(Request $request)
    {
        $id = $request->query->getInt('id');
        if (empty($id)) {
            return $this->msgResponse(2, '错误', '未找到角色组信息', 'rbac_role');
        }
        $em = $this->getDoctrine()->getManager();
        $role = $em->getRepository('RbacBundle:Role')->find($id);
        if (empty($role)) {
            return $this->msgResponse(2, '错误', '未找到角色组信息', 'rbac_role');
        }
        $role->setNodes(explode(',', $role->getNodes()));
        // 获取菜单列表
        $menuList = $em->getRepository('SystemBundle:Menu')->getRoleList();
        if ($request->request->get('submit')) {
            $nodes = $request->request->get('nodes');
            if (empty($nodes) || ! is_array($nodes)) {
                return $this->msgResponse(2, '错误', '请选择分配的权限内容', 'rbac_role_set', [
                    'id' => $id
                ]);
            }
            
            $nodeNames = $nodess = [];
            foreach ($menuList as $v) {
                if (in_array($v['node'], $nodes)) {
                    $nodess[$v['node']] = $v['node'];
                    $nodess[$v['parentNode']] = $v['parentNode'];
                    $nodeNames[$v['node']] = $v['name'];
                }
            }
            ksort($nodess);
            $role->setNodes(implode(',', $nodess));
            ksort($nodeNames);
            $role->setNodenames(implode(',', $nodeNames));
            $em->persist($role);
            $em->flush();
            return $this->msgResponse(0, '成功', '设置权限成功', 'rbac_role');
        }
        
        return $this->render('@Rbac/Role/set.html.twig', [
            'menuList' => $menuList,
            'role' => $role
        ]);
    }

    /**
     *
     * 新增角色组
     * 
     * @param Request $request            
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $errors = [];
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role, [
            'is_new' => 1
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if($role->getLevel() == 2){
                    $role->setArea(implode(',', $role->getArea()));
                }
                $role->setIp($request->getClientIp());
                $em->persist($role);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '添加成功', 'rbac_role');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('@Rbac/Role/new.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function editAction(Request $request)
    {
        $id = $request->query->getInt('id');
        if (empty($id)) {
            return $this->msgResponse(2, '错误', '未找到角色组信息', 'rbac_role');
        }
        $em = $this->getDoctrine()->getManager();
        $errors = [];
        $role = $this->getDoctrine()
            ->getRepository('RbacBundle:Role')
            ->find($id);
        if (empty($role)) {
            return $this->msgResponse(2, '错误', '未找到角色组信息', 'rbac_role');
        }
        $role->setArea(explode(',', $role->getArea()));
        $form = $this->createForm(RoleType::class, $role, [
            'is_new' => 0
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if($role->getLevel() == 2){
                    $role->setArea(implode(',', $role->getArea()));
                }
                $role->setIp($request->getClientIp());
                $em->persist($role);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '编辑成功', 'rbac_role');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('@Rbac/Role/new.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    public function showAction(Request $request)
    {
        $id = $request->query->getInt('id');
        $role = $this->getDoctrine()
            ->getRepository('RbacBundle:Role')
            ->find($id);
        
        return $this->render('RbacBundle:Role:show.html.twig', [
            'role' => $role
        ]);
    }

    public function deleteAction(Request $request)
    {
        $id = $request->request->getInt('id');
        $item = $this->getDoctrine()
            ->getRepository('RbacBundle:Role')
            ->find($id);
        if (! $item) {
            return $this->json([
                'status' => 0,
                'msg' => '记录不存在'
            ]);
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
            return $this->json([
                'status' => 1,
                'msg' => '删除成功'
            ]);
        }
    }
}
