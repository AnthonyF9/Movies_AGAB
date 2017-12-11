<?php
$title = 'Accueil';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/header.php');


if (!empty($_GET['search']))  {
  $motclef = $_GET['search'];

  $sql = "SELECT * FROM all_movies
          WHERE 1 = 1
          AND directors LIKE :motclef OR title LIKE :motclef OR cast LIKE :motclef";

          if($_GET['years']) {
              $annee = $_GET['years'];

              $sql .= " AND year = :annee";
          }

    $query = $pdo->prepare($sql);
    $query->bindValue(':motclef','%'.$motclef.'%',PDO::PARAM_INT);
    $query->execute();
    $movies = $query->fetchAll();

    if(empty($movies)) {
      $fail = 'Aucun résultats pour cette recherche';
    } else {
       $fail ="";
    }
  }












if (isset($_GET['log'])) {
  if($_GET['log'] == 'out') {
    session_destroy();
    setcookie('userck', '', time()-3600, '/', 'localhost', false, true);
    header('Location: ./index.php');
  } else { header ('Location: ./index.php');}
}

?>

      <main>

        <h2 class="titlesearch"> Resultats de la recherche "<?= $motclef  ?>" "<?= $annee  ?>"</h2>
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
         ?>


      </main>

<?php
include_once('./inc/footer.php');
?>