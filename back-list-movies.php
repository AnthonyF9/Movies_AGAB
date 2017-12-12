

<?php include('inc/pdo.php');
session_start();
?>
<?php

$sql = "SELECT * FROM all_movies
        ORDER BY created DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$movies = $stmt->fetchAll();
?>

<?php include('inc/headerback.php'); ?>
<a href="details.php"></a>

  <table class="table">
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
<?php include('inc/footerback.php'); ?>
