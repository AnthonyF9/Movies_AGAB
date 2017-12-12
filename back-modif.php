<?php
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/headerback.php');

// condition pour supprimer
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "SELECT * FROM all_movies WHERE id = $id";
      $query = $pdo->prepare($sql);
      $query->execute();
      $movies = $query->fetch();
      // si client existe
    //  if(!empty($movies)) {
            // on l'efface de la BDD
      //       $sqlDelete = "DELETE FROM all-movies WHERE id = $id";
      //       $query = $pdo->prepare($sqlDelete);
      //       $query->execute();
      // }
echo '<pre>';
print_r($movies);
echo '<pre>';
?>

<?php include('inc/header.php') ;?>





<?php include('inc/footer.php'); ?>
