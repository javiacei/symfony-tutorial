<?php

namespace Acme\PortfolioBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getPostsOfCategoryWithName($categoryName)
    {
        $qb = $this->_em->createQueryBuilder();

         return $qb
            ->select('p')
            ->from('Acme\PortfolioBundle\Entity\Post', 'p')
            ->innerJoin('p.categories', 'c', 'WITH', 'c.name = :categoryName')
            ->getQuery()
            ->setParameter('categoryName', $categoryName)
            ->getResult()
        ;
    }
}
