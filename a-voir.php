<?php
$title = 'Votre liste';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
include_once('./cookies.php'); //pdo, fonctions et sesions_start apppelés dedans

if(is_logged() == true){
  $sql = "SELECT m.title AS title FROM notes AS n LEFT JOIN all_movies AS m ON m.id = n.id_movie ORDER BY n.created_at DESC";
  $query = $pdo->prepare($sql);
  $query->execute();
  $lists = $query->fetchAll();
}else{
  header('Location: ./index.php');
}


include_once('./inc/header.php');
?>

  <main class="list">

    <?php
    foreach ($lists as $key => $list) {
      echo single_affiche($list);
      echo $list['title'];
    }
    ?>

  </main>

<?php
include_once('./inc/footer.php');
?>
