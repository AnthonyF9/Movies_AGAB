

<?php
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/headerback.php');
if (is_admin() == true) {

}
else {
  header('Location: ./index.php');
}
?>
<?php

$sql = "SELECT * FROM all_movies
        ORDER BY created DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll();
?>
<main>
  <div id="wrapper">
    <div id="alpha">
      <table>
        <tr>
          <th>id</th>
          <th>title</th>
          <th>year</th>
          <th>rating</th>
          <th>actions</th>
        </tr>
        <?php
        foreach ($movies as $movie) {

           echo '<tr><td>'. $movie['id'] .'</td>';
           echo '<td>'. $movie['title'] . '</td>';
           echo '<td>'. $movie['year'] . '</td>';
           echo '<td>'. $movie['rating'] . '</td>';
           echo '<td><a href="details.php?movie='. $movie['slug'].'" class="btn btn-success">Voir sur le site</a>
                      <a href="back-modif.php?id='. $movie['id'].'" class="btn btn-success">Modifier</a>
                      <a href="back-delete.php?id='. $movie['id'].'" class="btn btn-success">Effacer</a>
                      </td></tr>';
         }
         ?>
      </table>
    </div>
  </div>
</main>


<?php include('inc/footerback.php'); ?>
