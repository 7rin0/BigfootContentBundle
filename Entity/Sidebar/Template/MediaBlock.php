<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MediaBlock
 *
 * @ORM\Entity()
 */
class MediaBlock extends Sidebar
{
    /**
     * @var string
     *
     * @ORM\Column(name="media", type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * Get parent template
     *
     * @return string
     */
    public function getParentTemplate()
    {
        return 'media_block';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'MediaBlock';
    }

    /**
     * @param string $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }
}
