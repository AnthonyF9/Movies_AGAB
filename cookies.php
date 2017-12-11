<?php
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
if (!empty($_COOKIE['userck']) && !isset($_SESSION['user'])) {
  $userck = $_COOKIE['userck'];
  $userck = explode('---', $userck);
  //Ici les requêtes
    //Déclaration de la requêteuserck
    $sqluserck = "SELECT * FROM users WHERE id=:id";
    //Préparation de la requêteuserck
    $queryuserck = $pdo->prepare($sqluserck);
    //Protection contre les injections SQL
    $queryuserck->bindValue(':id',$userck[0],PDO::PARAM_STR);
    //Exécution de la requêteUser
    $queryuserck->execute();
    $utilisateur = $queryuserck->fetch();
    $key = sha1($utilisateur['username'].$utilisateur['password'].$_SERVER['REMOTE_ADDR']);
  //Fin des requêtes
  if ($key == $userck[1]) {
    $_SESSION['user']= array(
      'pseudo' => $utilisateur['username'],
      'id'     => $utilisateur['id'],
      'role'   => $utilisateur['role'],
      'ip'     => $_SERVER["REMOTE_ADDR"],
    );
    setcookie('userck', $utilisateur['id'] . '---' . $key, time()+3600*24*5, '/', 'localhost', false, true);
  }
  else {
    setcookie('userck', '', time()-3600, '/', 'localhost', false, true);
  }
  // debug($utilisateur);
}
else {
  // echo 'C\'est vide !';
}
?>
