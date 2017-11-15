<?php

namespace BlogBundle\Repository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function findWeeklyPost()
    {
        $queryBuilder = $this->createQueryBuilder('post')
            ->addOrderBy('post.id', 'DESC')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}