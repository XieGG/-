<?php

namespace SystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu
 *
 * @ORM\Table(name="menu")
 * @ORM\Entity(repositoryClass="SystemBundle\Repository\MenuRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Menu
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
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=60, nullable=true)
     */
    private $icon;
    
    /**
     * @var string
     *
     * @ORM\Column(name="english_name", type="string", length=60)
     */
    private $englishName;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;
    
    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;
    
    /**
     * @var int
     *
     * @ORM\Column(name="node", type="integer")
     */
    private $node;
    
    /**
     * @var int
     *
     * @ORM\Column(name="parent_node", type="integer")
     */
    private $parentNode;
    
    /**
     * @var int
     *
     * @ORM\Column(name="active", type="smallint")
     */
    private $active;

    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime")
     */
    private $updateAt;
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    public function getDropName()
    {
        
        return str_pad($this->name, strlen($this->name) + ($this->level - 1) * 2, "-", STR_PAD_LEFT);
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Menu
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        
        return $this;
    }
    
    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
    
    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Menu
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Menu
     */
    public function setLevel($level)
    {
        $this->level = $level;
        
        return $this;
    }
    
    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Menu
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
     * @return Menu
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
     * Set englishName
     *
     * @param string $englishName
     *
     * @return Menu
     */
    public function setEnglishName($englishName)
    {
        $this->englishName = $englishName;

        return $this;
    }

    /**
     * Get englishName
     *
     * @return string
     */
    public function getEnglishName()
    {
        return $this->englishName;
    }

    /**
     * Set node
     *
     * @param integer $node
     *
     * @return Menu
     */
    public function setNode($node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return integer
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set parentNode
     *
     * @param integer $parentNode
     *
     * @return Menu
     */
    public function setParentNode($parentNode)
    {
        $this->parentNode = $parentNode;
        
        return $this;
    }
    
    /**
     * Get parntNode
     *
     * @return integer
     */
    public function getParentNode()
    {
        return $this->parentNode;
    }

    /**
     * Set active
     *
     * @param integer $active
     *
     * @return Menu
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
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
}
