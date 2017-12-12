<?php
$title = 'Accueil';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/header.php');


if (!empty($_POST['submitfiltres']))  {


  $sql = "SELECT * FROM all_movies
          WHERE 1 = 1";

          if(is_numeric($_POST['years'])) {
              $annee = $_POST['years'];
              $sql .= " AND year = :annee";
          }

          if(!empty($_POST['categ'])) {
              $categorie = $_POST['categ'];
              $sql .= " AND genres LIKE :categorie ";
          }

          // EN COURS
          if(!empty($_POST['popu'])) {
              $popularite = $_POST['popu'];
              if ($popularite == 'Les plus populaires') {
                $sql .= " AND 2 = 2 ORDER BY popularity DESC ";
              } else {
                $sql .= " AND 2 = 2 ORDER BY popularity ASC ";
              }

          }


          // if(!empty($_POST['search'])) {
          //     $motclef = $_POST['search'];
          //
          //     $sql .= "AND directors LIKE :motclef OR title LIKE :motclef OR cast LIKE :motclef";
          //
          // }


    $query = $pdo->prepare($sql);
    // $query->bindValue(':motclef','%'.$motclef.'%',PDO::PARAM_INT);
    if (!empty($_POST['categ'])) {
      $query->bindValue(':categorie','%'.$categorie.'%',PDO::PARAM_INT);
    }
    if (!empty($_POST['years']) && is_numeric($_POST['years'])) {
    $query->bindValue(':annee',$annee,PDO::PARAM_INT);
    }
    $query->execute();
    $movies = $query->fetchAll();


    if(empty($movies)) {
      $fail = 'Aucun résultats pour cette recherche';
    } else {
       $fail ="";
    }
  }


if (isset($_POST['log'])) {
  if($_POST['log'] == 'out') {
    session_destroy();
    setcookie('userck', '', time()-3600, '/', 'localhost', false, true);
    header('Location: ./index.php');
  } else { header ('Location: ./index.php');}
}



?>

      <main>

        <h2 class="titlesearch"> Resultats de la recherche <?php if(!empty($_POST['categ'])) { echo '"'.$categorie.'"'; } ?> <?php if (!empty($_POST['years']) && is_numeric($_POST['years'])) { echo '"'.$annee.'"'; } ?></h2>
        <p> <?= $fail ?> </p>

        <div id="flexAffiches">
        <?php
        foreach ($movies as $movie) {
          if (file_exists('posters/' . $movie['id'] . '.jpg')) { ?>
            <div class="affiche">
              <a href="./details.php?movie=<?= $movie['slug'] ?>">  <img class="img" src="posters/<?=$movie['id'] ?>.jpg" alt="<?= $movie['title'] ?>"/> </a>
            </div> <?php
          }
          else { ?>
            <div class="affiche">
              <a href="./details.php?movie=<?= $movie['slug'] ?>">  <div class="img sansimage"><p><?=$movie['title'] ?></p></div> </a>
            </div> <?php
          }
        }
        ?>
        </div>



      </main>

<?php
include_once('./inc/footer.php');
?>
