<?php
$title = 'Accueil';
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
include_once('./inc/header.php');


$sql = "SELECT * FROM all_movies ORDER BY id ASC";
//
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();



$numero = rand(0, count($movies));

if (isset($_GET['log'])) {
  if($_GET['log'] == 'out') {
    session_destroy();
    setcookie('auth', '', time()-3600, '/', 'localhost', false, true);
    header('Location: ./index.php');
  } else { header ('Location: ./index.php');}
}

?>

      <main>


        <button type="button" name="button"> + de films ! </button>

        <button type="button" name="button"> Filtres  </button>


        <?php


          if (file_exists('posters/' . $movies[$numero]['id'] . '.jpg')) { ?>
                <p><img src="posters/<?=$movies[$numero]['id'] ?>.jpg" alt="<?= $movies[$numero]['title'] ?>"/></p>; <?php
          } else { ?>
            <div id="whitePoster">
            <p><?=$movies[$numero]['title'] ?></p>;
          </div> <?php
          }

         ?>





      </main>

<?php
include_once('./inc/footer.php');
?>
