<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page;

use Doctrine\ORM\EntityRepository;

/**
 * Block2Repository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Block2Repository extends EntityRepository
{
    public function findOneByPageBlock($page, $block)
    {
        return $this
            ->createQueryBuilder('b')
            ->where('b.page = :page')
            ->andWhere('b.block = :block')
            ->setParameter('page', $page)
            ->setParameter('block', $block)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
