<?php
include_once('./cookies.php'); // pdo, session start et fonctions inside




//condition pour la Consultation




//condition d'Ajout de films




//condition de Modification un film
// $sql =  "UPDATE all_movies
//         SET title = ";
// UPDATE table_name
//  SET col1 = 'val_bla'
//  WHERE col3 = 'une_val';
//


// condition pour supprimer un film
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "SELECT * FROM all_movies WHERE id = $id";
      $query = $pdo->prepare($sql);
      $query->execute();
      $movies = $query->fetch();
      // si le film existe
    //  if(!empty($movies)) {
            // on l'efface de la BDD
      //       $sqlDelete = "DELETE FROM all-movies WHERE id = $id";
      //       $query = $pdo->prepare($sqlDelete);
      //       $query->execute();
 }



include_once('./inc/headerback.php');

echo '<pre>';
print_r($movies);
echo '<pre>';
?>
<form action="index.html" method="post">
<label for="slug">Slug :*</label>
<input type="text" name="slug" value="<?php echo $movies['slug']; ?>">

<label for="title">Title :*</label>
<input type="text" name="title" value="<?php echo $movies['title']; ?>">

<label for="year">Year</label>
<input type="number" name="year" value="<?php echo $movies['year']; ?>">

<label for="genres">Genres :*</label>
<input type="text" name="genres" value="<?php echo $movies['genres']; ?>">

<label for="plot">Plot :*</label>
<input type="text" name="plot" value="<?php echo $movies['plot']; ?>">

<label for="directors">Directors :*</label>
<input type="text" name="directors" value="<?php echo $movies['directors']; ?>">


<label for="cast">Cast :* </label>
<input type="text" name="cast" value="<?php echo $movies['cast']; ?>">

<label for="writers">Writers :*</label>
<input type="text" name="writers" value="<?php echo $movies['writers']; ?>">

<label for="">Runtime :* </label>
<input type="text" name="runtime" value="<?php echo $movies['runtime']; ?>">

<label for="">mpaa : *</label>
<input type="text" name="mpaa" value="<?php echo $movies['mpaa']; ?>">

<label for="">rating : *</label>
<input type="text" name="rating" value="<?php echo $movies['rating']; ?>">

<label for="">popularity</label>
<input type="text" name="popularity" value="<?php echo $movies['popularity']; ?>">

</form>



<?php include('inc/footerback.php'); ?>
