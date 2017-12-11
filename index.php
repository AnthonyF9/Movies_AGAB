<?php
$title = 'Accueil';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/header.php');


$sql = "SELECT * FROM all_movies ORDER BY rand() LIMIT 100";
//
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();

$sql = "SELECT DISTINCT year FROM all_movies ORDER BY year DESC";
//
$queryyear = $pdo->prepare($sql);
$queryyear->execute();
$dates = $queryyear->fetchAll();




foreach ($dates as $date) {
  $annees = $date['year'];
}

$errors = array();






$notesTable = array('Les plus populaires','Les moins populaires');


if (isset($_GET['log'])) {
  if($_GET['log'] == 'out') {
    session_destroy();
    setcookie('userck', '', time()-3600, '/', 'localhost', false, true);
    header('Location: ./index.php');
  } else { header ('Location: ./index.php');}
}

?>

      <main>
<?php
$sql = "SELECT DISTINCT genres FROM all_movies ORDER BY genres ASC";
$query = $pdo->prepare($sql);
$query->execute();
$genres = $query->fetchAll();

$grandTableau = array();
foreach ($genres as $genre) {
  if ($genre['genres'] != '') {
    $grandTableau[] = $genre['genres'];
  }
}
$list = implode(', ',$grandTableau);
$tab = explode(', ',$list);
$tableau = array_unique($tab);
array_pop($tableau);



?>
        <div id="buttons">
          <a href="index.php"><button type="button" name="button"> + de films ! </button></a>

          <button type="button" name="button" id="hide"> Filtres  </button>
            <form id="form" class="show" action="index.php" method="post">
              <div id="genreFilm"><?php
                foreach ($tableau as $genre) {
                  nouvelInputSQL2($genre,'checkbox','categ','',$errors);
                } ?>
              </div><?php
              nouveauSelect2('Année','years','???? ',$errors,$annees);
              nouveauSelect2('Popularité','notes','???? ',$errors,$notesTable);
              nouvelInputSQL2('Recherche','text','search','Rechercher un film',$errors) ?>
              <input type="submit" value="Submit">
            </form>
        </div>

        <?php



        ?>



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
