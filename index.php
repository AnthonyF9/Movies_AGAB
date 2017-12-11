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



  $notesTable = array('Les plus populaires','Les moins populaires');

  $errors = array();

  if(!empty($_POST['submitfiltres'])) {


  }

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




  if (isset($_GET['log'])) {
    if($_GET['log'] == 'out') {
      session_destroy();
      setcookie('userck', '', time()-3600, '/', 'localhost', false, true);
      header('Location: ./index.php');
    } else { header ('Location: ./index.php');}
  }


?>

      <main>

        <div id="buttons">
          <a href="index.php"><button type="button" name="button"> + de films ! </button></a>

          <button type="button" name="button" id="hide"> Filtres  </button>


            <form id="form" class="show" action="search.php" method="get">
              <div id="genreFilm"><?php
                foreach ($tableau as $genre) { ?>
                  <div>
                    <label class="label" for="categ"> <?= $genre ?> : </label>
                    <input class="input" type="checkbox" name="categ" placeholder="" value="<?= $genre ?>">
                  </div> <?php
                } ?>
              </div>
              <div>
                <label class="label" for="years">Année : </label>
                <select name="years">
                  <option value="all"> All </option>
                  <?php foreach ($dates as $date) { ?>
                    <option <?php if(!empty($_GET['years'])) { if($value == $_GET['years']) { echo 'selected="selected" ';}} ?> value="<?php echo $date['year']; ?>"><?php echo $date['year']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div>
                <label class="label" for="popu">Popularité : </label>
                <select name="popu">
                  <?php foreach ($notesTable as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"<?php if(!empty($_POST['popu'])) { if($_POST['popu'] == $key) { echo ' selected="selected"'; } } ?>><?php echo $value; ?></option>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <?php   nouvelInputSQL2('Recherche','text','search','Rechercher un film',$errors) ?>
              <input type="submit" name="submitfiltres" value="Submit" formnovalidate>

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
