<?php
$title = 'Liste des films';
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/headerback.php');
if (is_admin() == true) {

}
else {
  header('Location: ./index.php');
}
//nombre de films par page
$perpage = 100;
//numéro de pages
$page = 1;
//offset par défaut (écrasé par celui de l'URL si get['page'] n'est pas vide)
$offset = 0;
if (!empty($_GET['page'])) {
  $page = $_GET['page'];
  $offset = $page * $perpage - $perpage;
}
//Ici les requêtes
  //Déclaration de la requête0
  $sql = "SELECT * FROM all_movies WHERE 1=1 ORDER BY created DESC LIMIT $perpage OFFSET $offset";
  //Préparation de la requête0
  $query = $pdo->prepare($sql);
  //Exécution de la requête0
  $query->execute();
  $movies = $query->fetchAll();
  //Déclaration de la requête1
  $sql1 = "SELECT COUNT(id) FROM all_movies WHERE 1=1";
  //Préparation de la requête1
  $query1 = $pdo->prepare($sql1);
  //Exécution de la requête1
  $query1->execute();
  $nbArticles = $query1->fetchColumn();
  $nbPages = ceil($nbArticles / $perpage);
// if(!empty($_POST['submit'])) {
//   header('Location: ./back-list-movies.php?page='.$_POST['navpage']);
// }
?>

  <main>
    <div id="pagination" class="flex-row">
      <?php
        paginationIndex($page,$nbPages,'back-list-movies');
      ?>
    </div>
    <div id="alpha">
      <table>
        <tr>
          <th>Id</th>
          <th>Title</th>
          <th>Year</th>
          <th>Rating</th>
          <th>Actions</th>
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
  </main>





<?php include('inc/footerback.php'); ?>
