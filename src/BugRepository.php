<?php
// src/BugRepository.php

use Doctrine\ORM\EntityRepository;

class BugRepository extends EntityRepository
{
    public function getRecentBugs($number = 30)
    {
        $dql = "SELECT b, e, r 
                FROM Bug AS b
                JOIN b.engineer AS e
                JOIN b.reporter AS r 
                ORDER BY b.created DESC";

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getResult();
    }

    public function getRecentBugsArray($number = 30)
    {
        $dql = "SELECT b, e, r, p 
                FROM Bug AS b
                JOIN b.engineer AS e 
                JOIN b.reporter AS r 
                JOIN b.products p 
                ORDER BY b.created DESC";

        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getArrayResult();
    }

    public function getUsersBugs($userId, $number = 15)
    {
        $dql = "SELECT b, e, r 
                FROM Bug AS b 
                JOIN b.engineer AS e 
                JOIN b.reporter AS r 
                WHERE b.status = 'OPEN' AND (e.id = ?1 OR r.id = ?1) 
                ORDER BY b.created DESC";

        return $this->getEntityManager()->createQuery($dql)
            ->setParameter(1, $userId)
            ->setMaxResults($number)
            ->getResult();
    }

    public function getOpenBugsByProduct()
    {
        $dql = "SELECT p.id, p.name, count(b.id) AS openBugs 
                FROM Bug b 
                JOIN b.products AS p 
                WHERE b.status = 'OPEN' 
                GROUP BY p.id";

        return $this->getEntityManager()->createQuery($dql)->getScalarResult();
    }
}
