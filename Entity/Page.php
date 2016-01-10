<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Bigfoot\Bundle\ContentBundle\Entity\Page\Block as PageBlock;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block2 as PageBlock2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block3 as PageBlock3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block4 as PageBlock4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Block5 as PageBlock5;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar as PageSidebar;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2 as PageSidebar2;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3 as PageSidebar3;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4 as PageSidebar4;
use Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5 as PageSidebar5;
use Bigfoot\Bundle\ContentBundle\Model\Content;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page
 *
 * @Gedmo\TranslationEntity(class="Bigfoot\Bundle\ContentBundle\Entity\PageTranslation")
 * @ORM\Table(name="bigfoot_content_page")
 * @ORM\Entity(repositoryClass="Bigfoot\Bundle\ContentBundle\Entity\PageRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Page extends Content
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @Gedmo\Slug(fields={"title"}, updatable=false, unique=true)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string", length=255, nullable=true)
     */
    private $uniqueId;

    /**
     * @var string
     * 
     * @Gedmo\Translatable
     * @ORM\Column(name="seo_title", type="string", length=255, nullable=true)
     */
    protected $seoTitle;

    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="seo_description", type="text", nullable=true)
     */
    protected $seoDescription;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block2", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks2;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block3", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks3;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block4", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks4;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Block5", mappedBy="page", cascade={"persist", "remove"})
     */
    private $blocks5;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar2", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars2;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar3", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars3;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar4", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars4;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Bigfoot\Bundle\ContentBundle\Entity\Page\Sidebar5", mappedBy="page", cascade={"persist", "remove"})
     */
    private $sidebars5;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Attribute")
     * @ORM\JoinTable(name="bigfoot_page_attribute")
     */
    private $attributes;

    /**
     * @ORM\OneToMany(
     *   targetEntity="PageTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * Construct Page
     */
    public function __construct()
    {
        $this->blocks     = new ArrayCollection();
        $this->blocks2    = new ArrayCollection();
        $this->blocks3    = new ArrayCollection();
        $this->blocks4    = new ArrayCollection();
        $this->blocks5    = new ArrayCollection();
        $this->sidebars   = new ArrayCollection();
        $this->sidebars2  = new ArrayCollection();
        $this->sidebars3  = new ArrayCollection();
        $this->sidebars4  = new ArrayCollection();
        $this->sidebars5  = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->translations = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * @param string $seoTitle
     * @return $this
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * @param string $seoDescription
     * @return $this
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * Add block
     *
     * @param PageBlock $block
     * @return $this
     */
    public function addBlock(PageBlock $block)
    {
        $this->blocks[] = $block;

        return $this;
    }

    /**
     * Remove block
     *
     * @param PageBlock $block
     */
    public function removeBlock(PageBlock $block)
    {
        $this->blocks->removeElement($block);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks
     * @return $this
     */
    public function setBlocks($blocks)
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * Get blocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks()
    {
        $blocks = array();

        foreach ($this->blocks as $key => $block) {
            $blocks[$block->getPosition()] = $block;
        }

        ksort($blocks);

        $blocks = new ArrayCollection($blocks);

        return $blocks;
    }

    /**
     * Add block2
     *
     * @param PageBlock2 $block2
     * @return $this
     */
    public function addBlock2(PageBlock2 $block2)
    {
        $this->blocks2[] = $block2;

        return $this;
    }

    /**
     * Remove block2
     *
     * @param PageBlock2 $block2
     * @return $this
     */
    public function removeBlock2(PageBlock2 $block2)
    {
        $this->blocks2->removeElement($block2);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks2
     * @return $this
     */
    public function setBlocks2($blocks2)
    {
        $this->blocks2 = $blocks2;

        return $this;
    }

    /**
     * Get blocks2
     *
     * @return \Doctrine\Common\Collections\Collection
     * @return $this
     */
    public function getBlocks2()
    {
        $blocks = array();

        foreach ($this->blocks2 as $key => $block) {
            $blocks[$block->getPosition()] = $block;
        }

        ksort($blocks);

        $blocks = new ArrayCollection($blocks);

        return $blocks;
    }

    /**
     * Add block3
     *
     * @param PageBlock3 $block3
     * @return $this
     */
    public function addBlock3(PageBlock3 $block3)
    {
        $this->blocks3[] = $block3;

        return $this;
    }

    /**
     * Remove block3
     *
     * @param PageBlock3 $block3
     * @return $this
     */
    public function removeBlock3(PageBlock3 $block3)
    {
        $this->blocks3->removeElement($block3);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks3
     * @return $this
     */
    public function setBlocks3($blocks3)
    {
        $this->blocks3 = $blocks3;

        return $this;
    }

    /**
     * Get blocks3
     *
     * @return \Doctrine\Common\Collections\Collection
     * @return $this
     */
    public function getBlocks3()
    {
        $blocks = array();

        foreach ($this->blocks3 as $key => $block) {
            $blocks[$block->getPosition()] = $block;
        }

        ksort($blocks);

        $blocks = new ArrayCollection($blocks);

        return $blocks;
    }

    /**
     * Add block4
     *
     * @param PageBlock4 $block4
     * @return $this
     */
    public function addBlock4(PageBlock4 $block4)
    {
        $this->blocks4[] = $block4;

        return $this;
    }

    /**
     * Remove block4
     *
     * @param PageBlock4 $block4
     * @return $this
     */
    public function removeBlock4(PageBlock4 $block4)
    {
        $this->blocks4->removeElement($block4);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks4
     * @return $this
     */
    public function setBlocks4($blocks4)
    {
        $this->blocks4 = $blocks4;

        return $this;
    }

    /**
     * Get blocks4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks4()
    {
        $blocks = array();

        foreach ($this->blocks4 as $key => $block) {
            $blocks[$block->getPosition()] = $block;
        }

        ksort($blocks);

        $blocks = new ArrayCollection($blocks);

        return $blocks;
    }

    /**
     * Add block5
     *
     * @param PageBlock5 $block5
     * @return $this
     */
    public function addBlock5(PageBlock5 $block5)
    {
        $this->blocks5[] = $block5;

        return $this;
    }

    /**
     * Remove block5
     *
     * @param PageBlock5 $block5
     * @return $this
     */
    public function removeBlock5(PageBlock5 $block5)
    {
        $this->blocks5->removeElement($block5);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $blocks5
     * @return $this
     */
    public function setBlocks5($blocks5)
    {
        $this->blocks5 = $blocks5;

        return $this;
    }

    /**
     * Get blocks5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocks5()
    {
        $blocks = array();

        foreach ($this->blocks5 as $key => $block) {
            $blocks[$block->getPosition()] = $block;
        }

        ksort($blocks);

        $blocks = new ArrayCollection($blocks);

        return $blocks;
    }

    /**
     * Add sidebar
     *
     * @param PageSidebar $sidebar
     * @return $this
     */
    public function addSidebar(PageSidebar $sidebar)
    {
        $this->sidebars[] = $sidebar;

        return $this;
    }

    /**
     * Remove sidebar
     *
     * @param PageSidebar $sidebar
     * @return $this
     */
    public function removeSidebar(PageSidebar $sidebar)
    {
        $this->sidebars->removeElement($sidebar);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars
     * @return $this
     */
    public function setSidebars($sidebars)
    {
        $this->sidebars = $sidebars;

        return $this;
    }

    /**
     * Get sidebars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars()
    {
        $sidebars = array();

        foreach ($this->sidebars as $key => $sidebar) {
            $sidebars[$sidebar->getPosition()] = $sidebar;
        }

        ksort($sidebars);

        $sidebars = new ArrayCollection($sidebars);

        return $sidebars;
    }

    /**
     * Add sidebars2
     *
     * @param PageSidebar2 $sidebars2
     * @return $this
     */
    public function addSidebar2(PageSidebar2 $sidebars2)
    {
        $this->sidebars2[] = $sidebars2;

        return $this;
    }

    /**
     * Remove sidebars2
     *
     * @param PageSidebar2 $sidebars2
     */
    public function removeSidebar2(PageSidebar2 $sidebars2)
    {
        $this->sidebars2->removeElement($sidebars2);
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars2
     * @return $this
     */
    public function setSidebars2($sidebars2)
    {
        $this->sidebars2 = $sidebars2;

        return $this;
    }

    /**
     * Get sidebars2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars2()
    {
        $sidebars = array();

        foreach ($this->sidebars2 as $key => $sidebar) {
            $sidebars[$sidebar->getPosition()] = $sidebar;
        }

        ksort($sidebars);

        $sidebars = new ArrayCollection($sidebars);

        return $sidebars;
    }

    /**
     * Add sidebars3
     *
     * @param PageSidebar3 $sidebars3
     * @return $this
     */
    public function addSidebar3(PageSidebar3 $sidebars3)
    {
        $this->sidebars3[] = $sidebars3;

        return $this;
    }

    /**
     * Remove sidebars3
     *
     * @param PageSidebar3 $sidebars3
     */
    public function removeSidebar3(PageSidebar3 $sidebars3)
    {
        $this->sidebars3->removeElement($sidebars3);
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars3
     * @return $this
     */
    public function setSidebars3($sidebars3)
    {
        $this->sidebars3 = $sidebars3;

        return $this;
    }

    /**
     * Get sidebars3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars3()
    {
        $sidebars = array();

        foreach ($this->sidebars3 as $key => $sidebar) {
            $sidebars[$sidebar->getPosition()] = $sidebar;
        }

        ksort($sidebars);

        $sidebars = new ArrayCollection($sidebars);

        return $sidebars;
    }

    /**
     * Add sidebars4
     *
     * @param PageSidebar4 $sidebars4
     * @return $this
     */
    public function addSidebar4(PageSidebar4 $sidebars4)
    {
        $this->sidebars4[] = $sidebars4;

        return $this;
    }

    /**
     * Remove sidebars4
     *
     * @param PageSidebar4 $sidebars4
     */
    public function removeSidebar4(PageSidebar4 $sidebars4)
    {
        $this->sidebars4->removeElement($sidebars4);
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars4
     * @return $this
     */
    public function setSidebars4($sidebars4)
    {
        $this->sidebars4 = $sidebars4;

        return $this;
    }

    /**
     * Get sidebars4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars4()
    {
        $sidebars = array();

        foreach ($this->sidebars4 as $key => $sidebar) {
            $sidebars[$sidebar->getPosition()] = $sidebar;
        }

        ksort($sidebars);

        $sidebars = new ArrayCollection($sidebars);

        return $sidebars;
    }

    /**
     * Add sidebars5
     *
     * @param PageSidebar5 $sidebars5
     * @return $this
     */
    public function addSidebar5(PageSidebar5 $sidebars5)
    {
        $this->sidebars5[] = $sidebars5;

        return $this;
    }

    /**
     * Remove sidebars5
     *
     * @param PageSidebar5 $sidebars5
     * @return $this
     */
    public function removeSidebar5(PageSidebar5 $sidebars5)
    {
        $this->sidebars5->removeElement($sidebars5);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $sidebars5
     * @return $this
     */
    public function setSidebars5($sidebars5)
    {
        $this->sidebars5 = $sidebars5;

        return $this;
    }

    /**
     * Get sidebars5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSidebars5()
    {
        $sidebars = array();

        foreach ($this->sidebars5 as $key => $sidebar) {
            $sidebars[$sidebar->getPosition()] = $sidebar;
        }

        ksort($sidebars);

        $sidebars = new ArrayCollection($sidebars);

        return $sidebars;
    }

    /**
     * @param Attribute $attribute
     * @return $this
     */
    public function addAttribute($attribute)
    {
        $this->attributes->add($attribute);

        return $this;
    }

    /**
     * @param Attribute $attribute
     * @return $this
     */
    public function removeAttribute($attribute)
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     * @return $this
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getArrayAttributes()
    {
        $toReturn = array();

        foreach ($this->attributes as $attribute) {
            if (!isset($toReturn[$attribute->getBlockPrefix()])) {
                $toReturn[$attribute->getBlockPrefix()] = array();
            }

            $toReturn[$attribute->getBlockPrefix()][] = $attribute->getValue();
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
     * @param PageTranslation $t
     */
    public function addTranslation(PageTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * @param string $uniqueId
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }
}
