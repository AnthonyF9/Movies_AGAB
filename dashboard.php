<?php
$title = 'Accueil';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php'); // pdo, session start et fonctions inside
include_once('./inc/headerback.php');
if (is_admin() == true) {

}
else {
  header('Location: ./index.php');
}
?>

      <main>



      </main>

<?php
include_once('./inc/footer.php');
?>
