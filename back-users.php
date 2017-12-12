<?php
$title = 'Gestion des utilisateurs de Movies AGAB';
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/headerback.php');
if (is_admin() == true) {

}
else {
  header('Location: ./index.php');
}
?>

      <main>
        <div id="gamma">
          <h1></h1>
          <?php

          ?>
        </div>
      </main>

<?php
include_once('./inc/footer.php');
?>
