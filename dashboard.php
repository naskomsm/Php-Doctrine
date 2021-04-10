<?php
// dashboard.php <user-id>
require_once "bootstrap.php";

$theUserId = $argv[1];

$dql = "SELECT b, e, r 
        FROM Bug AS b 
        JOIN b.engineer AS e 
        JOIN b.reporter AS r 
        WHERE b.status = 'OPEN' AND (e.id = ?1 OR r.id = ?1) 
        ORDER BY b.created DESC";

$myBugs = $entityManager->createQuery($dql)
    ->setParameter(1, $theUserId)
    ->setMaxResults(15)
    ->getResult();

echo "You have created or assigned to " . count($myBugs) . " open bugs:\n\n";

foreach ($myBugs as $bug) {
    echo $bug->getId() . " - " . $bug->getDescription() . "\n";
}
