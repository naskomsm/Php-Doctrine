<?php
// list_bugs.php
require_once "bootstrap.php";

$dql = "SELECT b, e, r 
        FROM Bug AS b 
        JOIN b.engineer AS e 
        JOIN b.reporter AS r 
        ORDER BY b.created DESC";

$query = $entityManager->createQuery($dql);
$query->setMaxResults(30);
$bugs = $query->getResult();

foreach ($bugs as $bug) {
    echo $bug->getDescription() . " - " . $bug->getCreated()->format('d.m.Y') . "\n";
    echo "    Reported by: " . $bug->getReporter()->getName() . "\n";
    echo "    Assigned to: " . $bug->getEngineer()->getName() . "\n";
    foreach ($bug->getProducts() as $product) {
        echo "    Platform: " . $product->getName() . "\n";
    }
    echo "\n";
}
