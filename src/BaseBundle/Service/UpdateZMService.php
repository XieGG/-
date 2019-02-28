<?php
namespace BaseBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use SystemBundle\Entity\Code;
use Doctrine\ORM\EntityManager;

class UpdateZMService
{

    private $doctrine;

    private $repo;

    private $em;

    public function __construct(Registry $doctrine, EntityManager $em)
    {
        $this->doctrine = $doctrine;
        $this->repo = $this->doctrine->getRepository('SystemBundle:Code');
        $this->em = $em;
    }

    public function getFzlx()
    {
        $zm = $this->repo->findBy([
            'codetypeid' => '11'
        ]);
        $arr = [];
        foreach ($zm as $k => $v) {
            $arr[$v->getCodename()] = $v->getCodenum();
        }
        return $arr;
    }

    public function updateDb($data)
    {
        if (!is_array($data)){
            return false;
        }
        $i = 0;
        foreach ($data['DATA'] as $val) {
            /**
             *
             * @var \SystemBundle\Entity\Code $obj
             */
            $obj = $this->repo->findOneBy([
                'codenum' => $val
            ]);
            if (empty($obj)) {
                $obj = new Code();
            }
            $obj->setCodenum($val['BH']);
            $obj->setCodename($val['MC']);
            $obj->setParentcode($val['LX']);
            $obj->setCodetypeid('94');
            $obj->setStatus('0');
            $this->em->persist($obj);
            $this->em->flush();
            $i++;
        }
        return $i;
    }
}