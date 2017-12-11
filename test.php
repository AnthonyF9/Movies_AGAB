<?php
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
$sql = "SELECT DISTINCT year FROM all_movies ORDER BY year DESC";
//
$queryyear = $pdo->prepare($sql);
$queryyear->execute();
$years = $queryyear->fetchAll();
debug($years);
?>
