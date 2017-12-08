<?php
$title = 'Accueil';
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
include_once('./inc/header.php');


$sql = "SELECT * FROM all_movies ORDER BY rand() LIMIT 100";
//
$query = $pdo->prepare($sql);
$query->execute();
$movies = $query->fetchAll();




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

        <div id="aaa">
        <?php
        foreach ($movies as $movie) {
          if (file_exists('posters/' . $movie['id'] . '.jpg')) { ?>
            <div class="affiche">
              <img class="img" src="posters/<?=$movie['id'] ?>.jpg" alt="<?= $movie['title'] ?>"/>
            </div> <?php
          }
          else { ?>
            <div class="affiche">
              <div class="img sansimage"><p><?=$movie['title'] ?></p></div>
            </div> <?php
          }
        }
        ?>
        </div>




      </main>

<?php
include_once('./inc/footer.php');
?>
