<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class CategoryRepository extends EntityRepository
{
    public function findAllInArray()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.id')
            ->addSelect('c.name')
            ->addSelect('cp.id as parent_category_id')
            ->leftJoin('c.parentCategory', 'cp');

        return $qb->getQuery()->getArrayResult();
    }
}
