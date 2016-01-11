<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Bigfoot\Bundle\ContentBundle\Entity\Page\Block as PageBlock;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 as PageBlock2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block3 as PageBlock3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block4 as PageBlock4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block5 as PageBlock5;
use Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block as SidebarBlock;
use Bigfoot\Bundle\ContentBundle\Model\Content;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Block
 *
 * @Gedmo\TranslationEntity(class="Bigfoot\Bundle\ContentBundle\Entity\BlockTranslation")
 * @ORM\Table(name="bigfoot_content_block")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\BlockRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Block extends Content
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"name"}, updatable=false, unique=true)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255, nullable=true)
     */
    protected $action;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block", mappedBy="block", cascade={"persist", "remove"})
     */
    private $pageBlocks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block2", mappedBy="block", cascade={"persist", "remove"})
     */
    private $pageBlocks2;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block3", mappedBy="block", cascade={"persist", "remove"})
     */
    private $pageBlocks3;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block4", mappedBy="block", cascade={"persist", "remove"})
     */
    private $pageBlocks4;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block5", mappedBy="block", cascade={"persist", "remove"})
     */
    private $pageBlocks5;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Block", mappedBy="block", cascade={"persist", "remove"})
     */
    private $sidebars;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Attribute")
     * @ORM\JoinTable(name="bigfoot_block_attribute")
     */
    private $attributes;

    /**
     * @ORM\OneToMany(
     *   targetEntity="BlockTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Construct Block
     */
    public function __construct()
    {
        $this->pageBlocks   = new ArrayCollection();
        $this->pageBlocks2  = new ArrayCollection();
        $this->pageBlocks3  = new ArrayCollection();
        $this->pageBlocks4  = new ArrayCollection();
        $this->pageBlocks5  = new ArrayCollection();
        $this->sidebars     = new ArrayCollection();
        $this->attributes   = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName().' - '.$this->getParentTemplate();
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
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return Block
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Add pageBlocks
     *
     * @param PageBlock $pageBlocks
     * @return Block
     */
    public function addPageBlock(PageBlock $pageBlock)
    {
        $this->pageBlocks->add($pageBlock);

        return $this;
    }

    /**
     * Remove pageBlocks
     *
     * @param PageBlock $pageBlocks
     */
    public function removePageBlock(PageBlock $pageBlock)
    {
        $this->pageBlocks->removeElement($pageBlock);

        return $this;
    }

    /**
     * Get pageBlocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks()
    {
        return $this->pageBlocks;
    }

    /**
     * Add pageBlocks2
     *
     * @param PageBlock $pageBlocks2
     * @return Block
     */
    public function addPageBlock2(PageBlock2 $pageBlock2)
    {
        $this->pageBlocks2->add($pageBlock2);

        return $this;
    }

    /**
     * Remove pageBlocks2
     *
     * @param PageBlock $pageBlocks2
     */
    public function removePageBlock2(PageBlock2 $pageBlock2)
    {
        $this->pageBlocks2->removeElement($pageBlock2);

        return $this;
    }

    /**
     * Get pageBlocks2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks2()
    {
        return $this->pageBlocks2;
    }

    /**
     * Add pageBlocks3
     *
     * @param PageBlock $pageBlocks3
     * @return Block
     */
    public function addPageBlock3(PageBlock3 $pageBlock3)
    {
        $this->pageBlocks3->add($pageBlock3);

        return $this;
    }

    /**
     * Remove pageBlocks3
     *
     * @param PageBlock $pageBlocks3
     */
    public function removePageBlock3(PageBlock3 $pageBlock3)
    {
        $this->pageBlocks3->removeElement($pageBlock3);

        return $this;
    }

    /**
     * Get pageBlocks3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks3()
    {
        return $this->pageBlocks3;
    }

    /**
     * Add pageBlocks4
     *
     * @param PageBlock $pageBlocks4
     * @return Block
     */
    public function addPageBlock4(PageBlock4 $pageBlock4)
    {
        $this->pageBlocks4->add($pageBlock4);

        return $this;
    }

    /**
     * Remove pageBlocks4
     *
     * @param PageBlock $pageBlocks4
     */
    public function removePageBlock4(PageBlock4 $pageBlock4)
    {
        $this->pageBlocks4->removeElement($pageBlock4);

        return $this;
    }

    /**
     * Get pageBlocks4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks4()
    {
        return $this->pageBlocks4;
    }

    /**
     * Add pageBlocks5
     *
     * @param PageBlock $pageBlocks5
     * @return Block
     */
    public function addPageBlock5(PageBlock5 $pageBlock5)
    {
        $this->pageBlocks5->add($pageBlock5);

        return $this;
    }

    /**
     * Remove pageBlocks5
     *
     * @param PageBlock $pageBlocks5
     */
    public function removePageBlock5(PageBlock5 $pageBlock5)
    {
        $this->pageBlocks5->removeElement($pageBlock5);

        return $this;
    }

    /**
     * Get pageBlocks5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageBlocks5()
    {
        return $this->pageBlocks5;
    }

    /**
     * Add sidebar
     *
     * @param SidebarBlock $sidebar
     * @return Block
     */
    public function addSidebar(SidebarBlock $sidebar)
    {
        $this->sidebars->add($sidebar);

        return $this;
    }

    /**
     * Remove sidebar
     *
     * @param SidebarBlock $sidebar
     */
    public function removeSidebar(SidebarBlock $sidebar)
    {
        $this->sidebars->removeElement($sidebar);

        return $this;
    }

    /**
     * Get sidebars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars()
    {
        return $this->sidebars;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param Attribute $attribute
     */
    public function addAttribute($attribute)
    {
        $this->attributes->add($attribute);

        return $this;
    }

    /**
     * @param Attribute $attribute
     */
    public function removeAttribute($attribute)
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $type
     * @return array
     */
    public function getArrayAttributes() {
        $toReturn = array();

        foreach ($this->attributes as $attribute) {
            if (!isset($toReturn[$attribute->getName()])) {
                $toReturn[$attribute->getName()] = array();
            }

            $toReturn[$attribute->getName()][] = $attribute->getValue();
        }

        return $toReturn;
    }

    /**
     * @return mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param BlockTranslation $t
     */
    public function addTranslation(BlockTranslation $t)
    {
        if ($this->translations && !$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }
}
