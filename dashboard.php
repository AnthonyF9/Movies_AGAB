

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
<a href="nwpost.php"></a>

  <table class="table table-sm">
<?php
    foreach ($movies as $movie) {

       echo '<tr><td>'. $movie['id'] .'</td>';
       echo '<td>'. $movie['title'] . '</td>';
       echo '<td>'. $movie['year'] . '</td>';
       echo '<td>'. $movie['rating'] . '</td>';
       echo '<td>'. $movie ['genres'] .'</td>';
        echo '<td>'. $movie['created'] .'</td>';
        echo '<td>'. $movie['modified'] .'</td>
<td><a href=".php?id='. $movie['id'].'" class="btn btn-success">Edit</a></td>
       </tr>';

     }
  ?>
</table>
<?php include('inc/footerback.php'); ?>
