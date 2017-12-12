<?php
$title = 'Votre liste';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
include_once('./cookies.php'); //pdo, fonctions et sesions_start apppelés dedans
if(is_logged() == true){
  $idUser = $_SESSION['user']['id'];
  $sql = "SELECT n.id_movie,n.id_user,n.note,a.title,a.slug
          FROM notes AS n
          LEFT JOIN all_movies AS a
          ON n.id_movie = a.id
          WHERE n.note IS NULL AND id_user=$idUser
          ORDER BY n.created_at DESC";
  $query = $pdo->prepare($sql);
  $query->execute();
  $lists = $query->fetchAll();
  // debug($lists);
}else{
  header('Location: ./index.php');
}


include_once('./inc/header.php');
?>

  <main class="list">

    <?php
    echo '<ul>';
    foreach ($lists as $key => $list) {
      echo '<li>'.$list['title'].'</li>';
      echo '<li>';
      echo list_affiche($list,'id_movie','title','slug');
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
