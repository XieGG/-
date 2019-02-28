<?php
namespace BaseBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use AdminBundle\Entity\NoticeInformation;

class InsertNoticeInfoService
{

    private $doctrine;

    private $em;

    public function __construct(Registry $doctrine, EntityManager $em)
    {
        $this->doctrine = $doctrine;
        $this->em = $em;
    }

    public function insertInfo($data)
    {
        $notice = new NoticeInformation();
        $notice->setXXID($data['XXID']);
        $notice->setXXBT($data['XXBT']);
        $notice->setXXNR($data['XXNR']);
        $notice->setFBSJ($data['FBSJ']);
        $notice->setFBZ($data['FBZ']);
        $notice->setMC($data['FJ']['MC']);
        $notice->setLX($data['FJ']['LX']);
        $notice->setNR($data['FJ']['NR']);
        $this->em->persist($notice);
        $this->em->flush();
        return $notice->getXXID();
    }
}