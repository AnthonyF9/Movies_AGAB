<?php
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');

for ($i=0; $i < 100 ; $i++) {
  $pseudo = 'a'.$i;
  $password1 = 'b'.$i;
  $mail = 'contact'.$i.'@gmail.com';
  $listecara = 'abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890';
  $token = substr(str_shuffle($listecara),2,68);
  //hashage du password
  $hashpassword = password_hash($password1,PASSWORD_BCRYPT);
  //Ici les requêtes
    //Déclaration de la requête0
    $sql = "INSERT INTO users(username,email,password,token,created_at,role) VALUES (:pseudo,:mail,:hashpassword,:token,NOW(),'user')";
    //Préparation de la requête0
    $query = $pdo->prepare($sql);
    //Protection contre les injections SQL
    $query->bindValue(':mail',$mail,PDO::PARAM_STR);
    $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
    $query->bindValue(':hashpassword',$hashpassword,PDO::PARAM_STR);
    $query->bindValue(':token',$token,PDO::PARAM_STR);
    //Exécution de la requête0
    $query->execute();
}
?>
