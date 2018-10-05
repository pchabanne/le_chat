<?php

use Doctrine\ORM\EntityRepository;

class repository extends EntityRepository
{
    public function findAllOrderedByName()
    {

        $dql = "SELECT b FROM Messages b";

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults(5);
        return $query->getResult();
    }
}