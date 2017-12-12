<?php
$title = 'Détail';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php');

if (!empty($_GET['movie'])) {
  $slug = $_GET['movie'];
  $sql = "SELECT * FROM all_movies WHERE slug = :movie";
  $query = $pdo->prepare($sql);
  $query->bindValue(':movie', $slug, PDO::PARAM_STR);
  $query->execute();
  $movie = $query->fetch();
  if (!empty($movie['slug'])) {
    //pas d'erreur
  }else {
    header('Location: ./404.php');
  }
}else{
  header('Location: ./404.php');
}


if(!empty($_POST['submitaddlist'])) {


         $sql = "INSERT INTO notes (id,id_user,id_movie,note,created_at) VALUES (:id,:id_user,:id_movie,'NULL',NOW())";
         $query = $pdo->prepare($sql);


         $query->execute();

         echo 'bravo';
      }




include_once('./inc/header.php');
?>

  <main class="affiche">

    <?php

        echo '<h1 class="titrefilm">'.$movie['title'].'</h1>';
        echo '<div class="titraffiche">';
        echo single_affiche($movie);
        echo '</div>';
        echo '<section class="detail">';
        echo '<p>Année : '.$movie['year'].'</p>';
        echo '<p>Genre : '.$movie['genres'].'</p>';
        echo '<p>Réalisateur : '.$movie['directors'].'</p>';
        echo '<p>Casting : '.$movie['cast'].'</p>';
        echo '<p>Scénariste : '.$movie['writers'].'</p>';
        echo '<p>Durée : '.$movie['runtime']. ' minutes' . '</p>';
        echo '<p>Limite d\'âge : '.$movie['mpaa'].'</p>';
        echo '<p>Note : '.$movie['rating'].'</p>';
        echo '<p>Popularité : '.$movie['popularity'].'</p>';
        echo '</section>';
        echo '<section class="synopsis">';
        echo '<p>'.$movie['plot'].'</p>';
        echo '</section>';



    ?>



    <div id="addlist" <?php if (!is_logged()){ echo 'style="display:none;"'; } ?> >
      <form id="formaddlist" action="" method="post">
        <label class="label" for="categ"> Ajouter à sa liste : </label>
        <input class="input" type="checkbox" name="addlist" placeholder="" value="addlist">
        <input type="submit" name="submitaddlist" value="Ajouter" formnovalidate>
      </form>
    </div>

  </main>

<?php
include_once('./inc/footer.php');
?>
