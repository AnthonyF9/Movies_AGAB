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
        <div id="alpha">
          <h1>Statistiques</h1>
          <?php
          // $sql = "SELECT id FROM all_movies WHERE 1=1";
          // $query = $pdo->prepare($sql);
          // $query->execute();
          // $user = $query->fetch();
          ?>
        </div>
      </main>

<?php
include_once('./inc/footer.php');
?>
