<?php
$title = 'Panneau de contrôle de Movies AGAB';
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/headerback.php');
if (is_admin() == true) {

}
else {
  header('Location: ./index.php');
}
?>

      <main>
        <div id="beta">
          <h1>Statistiques</h1>
          <?php
          //Nb de films dans la base de données
            $sql = "SELECT COUNT(*) FROM all_movies WHERE 1=1";
            $query = $pdo->prepare($sql);
            $query->execute();
            $nbFilms = $query->fetchColumn(); ?>
          <p><?php echo $nbFilms; ?> films dans la base de données</p>
          <?php
          //Nb d'utilisateurs
            $sql = "SELECT COUNT(*) FROM users WHERE 1=1";
            $query = $pdo->prepare($sql);
            $query->execute();
            $users = $query->fetchColumn(); ?>
          <p><?php echo $users; ?> utilisateurs</p>
          <h2>Inscriptions par semaine :</h2>
          <?php
          //Nb d'utilisateurs inscrits par semaine depuis les 5 dernières semaines
          $nbSemaines = 5;
          for ($i=$nbSemaines; $i > 0 ; $i--) {
            $sql = "SELECT COUNT(*) FROM users WHERE 1=1 AND created_at BETWEEN NOW()-interval 7*$i day AND NOW()-interval 7*($i-1) day";
            $query = $pdo->prepare($sql);
            $query->execute();
            $usersInscrits[$i] = $query->fetchColumn();
            ?>
            <p><?php echo $usersInscrits[$i]; ?> utilisateur(s) inscrit(s) <?php echo $i ?> semaine(s) plus tôt.</p> <?php
          }
          // debug($usersInscrits);
          $totalUserInscritsDernieresSemaines = array_sum($usersInscrits);
          $userInscritsParSemaine = $totalUserInscritsDernieresSemaines/$nbSemaines; ?>
          <p><?php echo $userInscritsParSemaine; ?> utilisateurs inscrits en moyenne par semaine depuis <?php echo $nbSemaines; ?> semaines.</p><?php
          //Les 30 films les plus ajoutés à des listes de films à voir
          ?><h2>Top 30 des films les plus ajoutés à des listes de films à voir :</h2><?php
          $sql = "SELECT a.title, COUNT(n.id_movie)
                  FROM notes AS n
                  LEFT JOIN all_movies AS a
                  ON n.id_movie = a.id
                  WHERE n.note IS NULL
                  GROUP BY n.id_movie
                  ORDER BY COUNT(n.id_movie) DESC LIMIT 30";
          $query = $pdo->prepare($sql);
          $query->execute();
          $filmsLesPlusAVoir = $query->fetchAll();
          // debug($filmsLesPlusAVoir);
          ?><ul><?php
          foreach ($filmsLesPlusAVoir as $topFilm) { ?>
            <li class="disc"><?php echo $topFilm['title'] ?></li><?php
          }
          ?></ul>
        </div>
      </main>

<?php
include_once('./inc/footer.php');
?>
