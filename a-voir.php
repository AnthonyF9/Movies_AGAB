<?php
$title = 'Votre liste';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
include_once('./cookies.php'); //pdo, fonctions et sesions_start apppelés dedans

if(is_logged() == true){
  $sql = "SELECT a.title AS title, n.id_movie AS id, a.slug AS movie, n.id_user = user
          FROM notes AS n
          LEFT JOIN all_movies AS a
          ON a.id = n.id_movie ORDER BY n.created_at DESC";
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
    echo '<ul>';
    foreach ($lists as $key => $list) {
      echo '<li>';
      echo list_affiche($list,'id','title','movie');
      echo '<br/>';
      echo $list['title'];
      echo '</li>';
    }
    echo '</ul>';
    ?>

  </main>

<?php
include_once('./inc/footer.php');
?>
