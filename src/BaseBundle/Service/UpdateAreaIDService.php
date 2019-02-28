<?php
namespace BaseBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SystemBundle\Entity\Administration;
use Doctrine\ORM\EntityManager;

class UpdateAreaIDService
{

    private $doctrine;
    private $em;

    public function __construct(Registry $doctrine,EntityManager $em)
    {
        $this->doctrine = $doctrine;
        $this->em = $em;
    }

   /**
    * update AreaID
    *
    * @param string $tablename
    * @param int $areaID
    * @param int $areaCode
    * @param array $arr
    * @return number
    */
    public function updateAreaID($data,$level,$parentId)
    {
        try {
            if(is_array($data['data'])){
                if(count($data['data']) == count($data['data'], 1)){
                    $v = $data['data'];
                    $i = 0;
                    $obj = $this->doctrine->getRepository('SystemBundle:Administration')->findOneBy([
                        'areaCode' => $v['AREACODE']
                    ]);
                    if (empty($obj)) {
                        $obj = $this->doctrine->getRepository('SystemBundle:Administration')->findOneBy([
                            'areaID' => $v['AREAID']
                        ]);
                        if(empty($obj)){
                            $obj = $this->doctrine->getRepository('SystemBundle:Administration')->findOneBy([
                                'areaName' => $v['AREANAME']
                            ]);
                            if(empty($obj)){
                                $obj= new Administration();
                            }
                        }
                    }
                    $obj->setAreaID($v['AREAID']);
                    if(is_array($v['AREACODE'])){
                        $obj->setAreaCode('');
                    }else{
                        $obj->setAreaCode($v['AREACODE']);
                    }
                    if(is_array($v['AREANAME'])){
                        $obj->setAreaName('');
                    }else{
                        $obj->setAreaName($v['AREANAME']);
                    }
                    if(is_array($v['ZXS'])){
                        $obj->setZXS('');
                    }else {
                        $obj->setZXS($v['ZXS']);
                    }
                    if(is_array($v['ZGX'])){
                        $obj->setZGX('');
                    }else {
                        $obj->setZGX($v['ZGX']);
                    }
                    $obj->setLevel($level);
                    $obj->setParentID($parentId);
                    $obj->setSUBMITSTATE('1');
                    $this->em->persist($obj);
                    $this->em->flush();
                    $i++;
                }else{
                    foreach ($data['data'] as $v){
                        $i = 0;
                        $obj = $this->doctrine->getRepository('SystemBundle:Administration')->findOneBy([
                            'areaCode' => $v['AREACODE']
                        ]);
                        if (empty($obj)) {
                            $obj = $this->doctrine->getRepository('SystemBundle:Administration')->findOneBy([
                                'areaID' => $v['AREAID']
                            ]);
                            if(empty($obj)){
                                $obj = $this->doctrine->getRepository('SystemBundle:Administration')->findOneBy([
                                    'areaName' => $v['AREANAME']
                                ]);
                                if(empty($obj)){
                                    $obj= new Administration();
                                }
                            }
                        }
                        $obj->setAreaID($v['AREAID']);
                        if(is_array($v['AREACODE'])){
                            $obj->setAreaCode('');
                        }else{
                            $obj->setAreaCode($v['AREACODE']);
                        }
                        if(is_array($v['AREANAME'])){
                            $obj->setAreaName('');
                        }else{
                            $obj->setAreaName($v['AREANAME']);
                        }
                        if(is_array($v['ZXS'])){
                            $obj->setZXS('');
                        }else {
                            $obj->setZXS($v['ZXS']);
                        }
                        if(is_array($v['ZGX'])){
                            $obj->setZGX('');
                        }else {
                            $obj->setZGX($v['ZGX']);
                        }
                        $obj->setLevel($level);
                        $obj->setParentID($parentId);
                        $this->em->persist($obj);
                        $this->em->flush();
                        $i++;
                    }
                }
                return $i;
            }else{
                return [];
            }
        }catch (\Exception $e){
            return [
                'code' => 4,
                'msg' => 'request exception',
                'data' => [
                    'exception_code' => $e->getCode(),
                    'exception_msg' => $e->getMessage()
                ]
            ];
        };
    }
}