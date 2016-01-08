<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Sidebar\Template;

use Bigfoot\Bundle\ContentBundle\Entity\Sidebar;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Block
 *
 * @ORM\Entity()
 */
class Block extends Sidebar
{
    /**
     * Get parent template
     *
     * @return string
     */
    public function getParentTemplate()
    {
        return 'block';
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'Block';
    }
}