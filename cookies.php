<?php
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
if (!empty($_COOKIE['auth']) && !isset($_SESSION['user'])) {
  $auth = $_COOKIE['auth'];
  $auth = explode('-----', $auth);
  //Ici les requêtes
    //Déclaration de la requêteAuth
    $sqlAuth = "SELECT id,username,role,token FROM users WHERE id=:id";
    //Préparation de la requêteAuth
    $queryAuth = $pdo->prepare($sqlAuth);
    //Protection contre les injections SQL
    $queryAuth->bindValue(':id',$auth[0],PDO::PARAM_STR);
    //Exécution de la requêteUser
    $queryAuth->execute();
    $utilisateur = $queryAuth->fetch();
    $key = sha1($utilisateur['username'] . $utilisateur['token'] . $_SERVER["REMOTE_ADDR"]);
  //Fin des requêtes
  if ($key == $auth[1]) {
    $_SESSION['user']= array(
      'pseudo' => $utilisateur['username'],
      'id'     => $utilisateur['id'],
      'role'   => $utilisateur['role'],
      'ip'     => $_SERVER["REMOTE_ADDR"],
    );
    setcookie('auth', $utilisateur['id'] . '-----' . $key, time()+3600*24*3, '/', 'localhost', false, true);
  }
  else {
    setcookie('auth', '', time()-3600, '/', 'localhost', false, true);
  }
  // debug($utilisateur);
}
else {
  // echo 'C\'est vide !';
}
?>
