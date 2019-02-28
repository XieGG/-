<?php

namespace RbacBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="RbacBundle\Repository\RoleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"rolename"},
 *     message="角色名称已存在"
 * )
 */
class Role implements RoleInterface
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
     * @ORM\Column(name="rolename", type="string", length=32, options={"comment": "角色名称"})
     * @Assert\NotBlank(message="角色名称不能为空")
     */
    private $rolename;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, options={"comment": "角色备注"})
     * @Assert\NotBlank(message="角色备注不能为空")
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint", nullable=true,options={"comment":"角色等级，0系统超级管理员，1厅级，2市，3县区，4司法所"})
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", options={"comment": "状态，0禁用，1正常"})
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="nodes", type="text", nullable=true, options={"comment": "菜单列表（menu node 以,隔开）"})
     */
    private $nodes;

    /**
     * @var string
     *
     * @ORM\Column(name="nodenames", type="text", nullable=true, options={"comment": "菜单名称"})
     */
    private $nodenames;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", options={"comment": "创建时间"})
     */
    private $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime", options={"comment": "更新时间"})
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=32, options={"comment": "IP"})
     */
    private $ip;
    
    /**
     * @var string
     *
     * @ORM\Column(name="area", type="string", length=255, nullable=true, options={"comment": "负责地市"})
     */
    private $area;

     /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="gROUP", cascade={"remove"})
     */
    private $users;

    /**
     * @var string
     *
     * @ORM\Column(name="sort", type="string", length=255, nullable=true, options={"comment": "市级排序 1 市一审 2 市二审"})
     */
    private $sort;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    /**
     * 
     * 
     */
    public function getRole()
    {
        return 'ROLE_ADMIN_' . $this->id;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rolename
     *
     * @param string $rolename
     *
     * @return Role
     */
    public function setRolename($rolename)
    {
        $this->rolename = $rolename;

        return $this;
    }

    /**
     * Get rolename
     *
     * @return string
     */
    public function getRolename()
    {
        return $this->rolename;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Role
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Role
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return Role
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Role
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Role
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Role
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
    
    /**
     * Set area
     *
     * @param string $area
     *
     * @return Role
     */
    public function setArea($area)
    {
        $this->area = $area;
        
        return $this;
    }
    
    /**
     * Get area
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if($this->getCreateAt() == null){
            $this->setCreateAt(new \DateTime());
        }
        $this->setUpdateAt(new \DateTime());
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUpdateAt(new \DateTime());
    }

    /**
     * Add user
     *
     * @param \RbacBundle\Entity\User $user
     *
     * @return Role
     */
    public function addUser(\RbacBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \RbacBundle\Entity\User $user
     */
    public function removeUser(\RbacBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set nodes.
     *
     * @param string|null $nodes
     *
     * @return Role
     */
    public function setNodes($nodes = null)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * Get nodes.
     *
     * @return string|null
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * Set nodenames.
     *
     * @param string|null $nodenames
     *
     * @return Role
     */
    public function setNodenames($nodenames = null)
    {
        $this->nodenames = $nodenames;

        return $this;
    }

    /**
     * Get nodenames.
     *
     * @return string|null
     */
    public function getNodenames()
    {
        return $this->nodenames;
    }

    /**
     * Set sort.
     *
     * @param string|null $sort
     *
     * @return Role
     */
    public function setSort($sort = null)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort.
     *
     * @return string|null
     */
    public function getSort()
    {
        return $this->sort;
    }
}
