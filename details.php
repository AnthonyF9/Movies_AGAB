<?php
$title = 'Accueil';
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
include_once('./inc/header.php');
?>



  <main class="affiche">

    <?php

    //Attention : nom de variables et de fonctions provisoire ^^
    if (!empty($_GET['movie'])) {
    $slug = $_GET['movie'];
    $sql = "SELECT * FROM all_movies WHERE slug = :movie";
    $query = $pdo->prepare($sql);
    $query->bindValue(':movie', $slug, PDO::PARAM_STR);
    $query->execute();
    $movie = $query->fetch();
    }else{
      die('404');
    }


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
        echo '<p>Durée : '.$movie['runtime'].'</p>';
        echo '<p>Limite d\'âge : '.$movie['mpaa'].'</p>';
        echo '<p>Note : '.$movie['rating'].'</p>';
        echo '<p>Popularité : '.$movie['popularity'].'</p>';
        echo '</section>';
        echo '<section class="synopsis">';
        echo '<p>'.$movie['plot'].'</p>';
        echo '</section>';

    ?>

  </main>

<?php
include_once('./inc/footer.php');
?>
