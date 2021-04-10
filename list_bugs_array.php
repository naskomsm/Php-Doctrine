<?php
// list_bugs_array.php
require_once "bootstrap.php";

$dql = "SELECT b, e, r, p 
        FROM Bug AS b 
        JOIN b.engineer AS e 
        JOIN b.reporter AS r 
        JOIN b.products AS p 
        ORDER BY b.created DESC";
        
$query = $entityManager->createQuery($dql);
$bugs = $query->getArrayResult();

foreach ($bugs as $bug) {
    echo $bug['description'] . " - " . $bug['created']->format('d.m.Y') . "\n";
    echo "    Reported by: " . $bug['reporter']['name'] . "\n";
    echo "    Assigned to: " . $bug['engineer']['name'] . "\n";
    foreach ($bug['products'] as $product) {
        echo "    Platform: " . $product['name'] . "\n";
    }
    echo "\n";
}
