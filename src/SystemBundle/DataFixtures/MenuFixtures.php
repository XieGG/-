<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 19-2-28
 * Time: 下午7:26
 */
namespace SystemBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use SystemBundle\Entity\Menu;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $result = $this->truncateTable($manager);
        if ($result['code'] == 0) {
            echo $result['msg'];
            return false;
        }
        /**
         *
         * @var \SystemBundle\Repository\MenuRepository $repo
         */
        $repo = $manager->getRepository('SystemBundle:Menu');
        $createAt = new \DateTime();
        foreach ($this->getMenuList() as $val) {
            $menu = $repo->findOneBy([
                'node' => $val['node']
            ]);
            if (empty($menu)) {
                $menu = new Menu();
            }
            $menu->setName($val['name']);
            $menu->setEnglishName($val['english_name']);
            $menu->setParentNode($val['parent_node']);
            $menu->setLevel($val['level']);
            $menu->setStatus($val['status']);
            $menu->setActive($val['active']);
            $menu->setNode($val['node']);
            if (isset($val['icon'])) {
                $menu->setIcon($val['icon']);
            }
            $menu->setCreateAt($createAt);
            $menu->setUpdateAt($createAt);
            $manager->persist($menu);
            $manager->flush();
        }
    }

    private function truncateTable($em)
    {
        $classMetaData = $em->getClassMetadata(Menu::class);
        $connection = $em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($classMetaData->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
            return [
                'code' => 1,
                'msg' => '执行成功'
            ];
        } catch (\Exception $e) {
            $connection->rollback();
            return [
                'code' => 0,
                'msg' => '执行失败'
            ];
        }
    }

    /**
     * 系统首页板块
     *
     * @return string[][]|number[][]
     */
    private function getAdminMenu()
    {
        $parentNode = 10000;
        $menu = [
            [
                'name' => '系统首页',
                'english_name' => 'admin_homepage',
                'parent_node' => $parentNode,
                'level' => 2,
                'status' => 1,
                'active' => 1,
                'node' => 10100 // 排序在父级的基础上增加
            ],
        ];
        return $menu;
    }


    /**
     *
     * @return string[]
     */
    private function getMenuList()
    {
        // node 越小优先级越高， 大菜单的level=1，小菜单level=2，内页的顶部菜单level=3
        $menu = [
            [
                'name' => '梦起源服务器后台管理系统',
                'english_name' => 'admin_homepage',
                'parent_node' => 0,
                'level' => 0,
                'status' => 1,
                'active' => 0,
                'node' => 1
            ],
            [
                'name' => '首页',
                'english_name' => 'admin_homepage',
                'parent_node' => 1,
                'level' => 1,
                'status' => 1,
                'active' => 1,
                'icon' => 'icon-home',
                'node' => 10000
            ],

        ];
        // 菜单合并
        $arr = array_merge($menu, $this->getAdminMenu());
        return $arr;
    }
}