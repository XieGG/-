<?php

namespace RbacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user", options={"comment":"用户表"},
 *     indexes={
 *          @ORM\Index(name="USERNAME_idx", columns={"USERNAME"})
 *      })))
 * @ORM\Entity(repositoryClass="RbacBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"uSERNAME"},
 *     message="{{ value }}已存在"
 * )
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="USERNAME", type="string", length=11, nullable=true, unique=true, options={"comment": "用户手机号"})
     * @Assert\NotBlank(message="请填写用户手机号")
     * */
    private $uSERNAME;
    
    /**
     * @var string
     *
     * @ORM\Column(name="XM", type="string", length=32, options={"comment": "用户真实姓名"})
     * @Assert\NotBlank(message="真实姓名不能为空")
     */
    private $xM;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="RYBM",type="string",nullable=true,length=22,options={"comment":"人员编号"})
     */
    private $rYBM;
    
    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=60, options={"comment": "密码"})
     * @Assert\NotBlank(message="密码不能为空")
     */
    private $pASSWORD;
    
    /**
     * @var string
     *
     * @ORM\Column(name="SALT", type="string", length=13, options={"comment": "密码盐值，13位"})
     */
    private $sALT;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="CREATEAT", type="datetime", options={"comment": "创建时间"})
     */
    private $cREATEAT;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="UPDATEAT", type="datetime", options={"comment": "更新时间"})
     */
    private $uPDATEAT;

    /**
     * @var string
     *
     * @ORM\Column(name="IP", type="string",  length=32, options={"comment": "IP"})
     */
    private $IP;
    
    /**
     * @var int
     *
     * @ORM\Column(name="LEVEL", type="smallint", options={"comment": "用户级别，0系统管理员，1厅级，2市级，3区县级，4所级"})
     */
    private $lEVEL;
    
    /**
     * @var int
     *
     * @ORM\Column(name="ROLEID", type="integer", options={"comment": "角色ID"})
     * @Assert\NotBlank(message="请选择角色组")
     */
    private $rOLEID;

    /**
     * @var string
     *
     * @ORM\Column(name="ROLE", type="string",  length=32, options={"comment": "角色名"})
     */
    private $rOLE;

    /**
     * @var int
     *
     * @ORM\Column(name="STATUS", type="smallint", options={"comment": "状态，0禁用，1启用"})
     */
    private $sTATUS;
    
    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="ROLEID", referencedColumnName="id", onDelete="CASCADE")
     */
    private $gROUP;
    /**
     * Get role
     *
     * @return Role
     */
    public function getRoles()
    {
        return [$this->getRole()];
    }
    
    public function eraseCredentials()
    {}
    
    public function getPassword()
    {
        return $this->pASSWORD;
    }
    
    public function getSalt()
    {
        return $this->sALT;
    }
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
     */
    public function getUsername()
    {
        return $this->uSERNAME;
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set uSERNAME
     *
     * @param string $uSERNAME
     *
     * @return User
     */
    public function setUSERNAME($uSERNAME)
    {
        $this->uSERNAME = $uSERNAME;

        return $this;
    }

    /**
     * Set xM
     *
     * @param string $xM
     *
     * @return User
     */
    public function setXM($xM)
    {
        $this->xM = $xM;

        return $this;
    }

    /**
     * Get xM
     *
     * @return string
     */
    public function getXM()
    {
        return $this->xM;
    }

    /**
     * Set rYBM
     *
     * @param string $rYBM
     *
     * @return User
     */
    public function setRYBM($rYBM)
    {
        $this->rYBM = $rYBM;

        return $this;
    }

    /**
     * Get rYBM
     *
     * @return string
     */
    public function getRYBM()
    {
        return $this->rYBM;
    }

    /**
     * Set sALT
     *
     * @param string $sALT
     *
     * @return User
     */
    public function setSALT($sALT)
    {
        $this->sALT = $sALT;

        return $this;
    }

    /**
     * Set cREATEAT
     *
     * @param \DateTime $cREATEAT
     *
     * @return User
     */
    public function setCREATEAT($cREATEAT)
    {
        $this->cREATEAT = $cREATEAT;

        return $this;
    }

    /**
     * Get cREATEAT
     *
     * @return \DateTime
     */
    public function getCREATEAT()
    {
        return $this->cREATEAT;
    }

    /**
     * Set iP
     *
     * @param string $iP
     *
     * @return User
     */
    public function setIP($iP)
    {
        $this->IP = $iP;

        return $this;
    }

    /**
     * Get iP
     *
     * @return string
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * Set lEVEL
     *
     * @param integer $lEVEL
     *
     * @return User
     */
    public function setLEVEL($lEVEL)
    {
        $this->lEVEL = $lEVEL;
        
        return $this;
    }
    
    /**
     * Get lEVEL
     *
     * @return integer
     */
    public function getLEVEL()
    {
        return $this->lEVEL;
    }
    /**
     * Set rOLEID
     *
     * @param integer $rOLEID
     *
     * @return User
     */
    public function setROLEID($rOLEID)
    {
        $this->rOLEID = $rOLEID;

        return $this;
    }

    /**
     * Get rOLEID
     *
     * @return integer
     */
    public function getROLEID()
    {
        return $this->rOLEID;
    }

    /**
     * Set rOLE
     *
     * @param string $rOLE
     *
     * @return User
     */
    public function setROLE($rOLE)
    {
        $this->rOLE = $rOLE;

        return $this;
    }

    /**
     * Get rOLE
     *
     * @return string
     */
    public function getROLE()
    {
        return $this->rOLE;
    }

    /**
     * Set sTATUS
     *
     * @param integer $sTATUS
     *
     * @return User
     */
    public function setSTATUS($sTATUS)
    {
        $this->sTATUS = $sTATUS;

        return $this;
    }

    /**
     * Get sTATUS
     *
     * @return integer
     */
    public function getSTATUS()
    {
        return $this->sTATUS;
    }

//    /**
//     * Set jZJGSZDSSFJ
//     *
//     * @param string $jZJGSZDSSFJ
//     *
//     * @return User
//     */
//    public function setJZJGSZDSSFJ($jZJGSZDSSFJ)
//    {
//        $this->jZJGSZDSSFJ = $jZJGSZDSSFJ;
//
//        return $this;
//    }
//
//    /**
//     * Get jZJGSZDSSFJ
//     *
//     * @return string
//     */
//    public function getJZJGSZDSSFJ()
//    {
//        return $this->jZJGSZDSSFJ;
//    }
//
//    /**
//     * Set jZJGSZDSSFJMC
//     *
//     * @param string $jZJGSZDSSFJMC
//     *
//     * @return User
//     */
//    public function setJZJGSZDSSFJMC($jZJGSZDSSFJMC)
//    {
//        $this->jZJGSZDSSFJMC = $jZJGSZDSSFJMC;
//
//        return $this;
//    }
//
//    /**
//     * Get jZJGSZDSSFJMC
//     *
//     * @return string
//     */
//    public function getJZJGSZDSSFJMC()
//    {
//        return $this->jZJGSZDSSFJMC;
//    }
//
//    /**
//     * Set jZJGSZQXSFJ
//     *
//     * @param string $jZJGSZQXSFJ
//     *
//     * @return User
//     */
//    public function setJZJGSZQXSFJ($jZJGSZQXSFJ)
//    {
//        $this->jZJGSZQXSFJ = $jZJGSZQXSFJ;
//
//        return $this;
//    }
//
//    /**
//     * Get jZJGSZQXSFJ
//     *
//     * @return string
//     */
//    public function getJZJGSZQXSFJ()
//    {
//        return $this->jZJGSZQXSFJ;
//    }
//
//    /**
//     * Set jZJGSZQXSFJMC
//     *
//     * @param string $jZJGSZQXSFJMC
//     *
//     * @return User
//     */
//    public function setJZJGSZQXSFJMC($jZJGSZQXSFJMC)
//    {
//        $this->jZJGSZQXSFJMC = $jZJGSZQXSFJMC;
//
//        return $this;
//    }
//
//    /**
//     * Get jZJGSZQXSFJMC
//     *
//     * @return string
//     */
//    public function getJZJGSZQXSFJMC()
//    {
//        return $this->jZJGSZQXSFJMC;
//    }
//
//    /**
//     * Set jZJGSZSFS
//     *
//     * @param string $jZJGSZSFS
//     *
//     * @return User
//     */
//    public function setJZJGSZSFS($jZJGSZSFS)
//    {
//        $this->jZJGSZSFS = $jZJGSZSFS;
//
//        return $this;
//    }
//
//    /**
//     * Get jZJGSZSFS
//     *
//     * @return string
//     */
//    public function getJZJGSZSFS()
//    {
//        return $this->jZJGSZSFS;
//    }
//
//    /**
//     * Set jZJGSZSFSMC
//     *
//     * @param string $jZJGSZSFSMC
//     *
//     * @return User
//     */
//    public function setJZJGSZSFSMC($jZJGSZSFSMC)
//    {
//        $this->jZJGSZSFSMC = $jZJGSZSFSMC;
//
//        return $this;
//    }
//
//    /**
//     * Get jZJGSZSFSMC
//     *
//     * @return string
//     */
//    public function getJZJGSZSFSMC()
//    {
//        return $this->jZJGSZSFSMC;
//    }

    /**
     * Set gROUP
     *
     * @param \RbacBundle\Entity\Role $gROUP
     *
     * @return User
     */
    public function setGROUP(\RbacBundle\Entity\Role $gROUP = null)
    {
        $this->gROUP = $gROUP;

        return $this;
    }

    /**
     * Get gROUP
     *
     * @return \RbacBundle\Entity\Role
     */
    public function getGROUP()
    {
        return $this->gROUP;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if($this->getCREATEAT() == null){
            $this->setCREATEAT(new \DateTime());
        }
        $this->setUPDATEAT(new \DateTime());
    }
    
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUPDATEAT(new \DateTime());
    }

    /**
     * Set uPDATEAT.
     *
     * @param \DateTime $uPDATEAT
     *
     * @return User
     */
    public function setUPDATEAT($uPDATEAT)
    {
        $this->uPDATEAT = $uPDATEAT;

        return $this;
    }

    /**
     * Get uPDATEAT.
     *
     * @return \DateTime
     */
    public function getUPDATEAT()
    {
        return $this->uPDATEAT;
    }

    /**
     * Set pASSWORD.
     *
     * @param string $pASSWORD
     *
     * @return User
     */
    public function setPASSWORD($pASSWORD)
    {
        $this->pASSWORD = $pASSWORD;

        return $this;
    }
}
