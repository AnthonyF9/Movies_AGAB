<?php
$title = 'Demander un nouveau mot de passe';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php');
global $pdo;
ifIs_logged($location='index');
$errors = array();
$success = false;
if (!empty($_POST['submitted'])) {
  //Se protéger contre les failles XSS (retire les balises qui pourraient être soumises dans les champs) grace à strip_tags()
  //Supprimer les espaces avant ou après avec trim()
  $mail = trim(strip_tags($_POST['mail']));
  // Vérifier que le mail est bien un mail
  if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    //Vérifier que le mail n'existe pas déjà
    //Ici les requêtes
      //Déclaration de la requêteVerifUserExist
      $sqlVerifUserExist = "SELECT * FROM users WHERE email=:mail";
      //Préparation de la requêteVerifUserExist
      $queryVerifUserExist = $pdo->prepare($sqlVerifUserExist);
      //Protection contre les injections SQL
      $queryVerifUserExist->bindValue(':mail',$mail,PDO::PARAM_STR);;
      //Exécution de la requêteVerifUserExist
      $queryVerifUserExist->execute();
      $verifUserExist = $queryVerifUserExist->fetch();
    //Fin des requêtes
    if (empty($verifUserExist['email'])) {
      $errors['mail'] = 'Ce mail ne correspond à aucun utilisateur.';
    }
  }
  //Vérifier que tout est correct
  if (count($errors) == 0) {
    $success = true;
    $mailBDD = urlencode($verifUserExist['email']);
    $tokenBDD = $verifUserExist['token'];
    //Mail avec phpmailer
    include_once('./mailer.php');
    header('Location: ./forgotten-password.php?recovery=true');
    //  //Mail avec la fonction mail()
    // mail($mailBDD,'Modifier votre mot de passe pour "inscription-connexion"','http://localhost/projet/3-06dec2017/inscription-connexion/modif-password.php?mail=' . $mailBDD . '&token=' . $tokenBDD);
    // header('Location: ./forgotten-password.php?recovery=true');
    // //Pas de mail
    // header('Location: ./modif-password.php?mail=' . $mailBDD . '&token=' . $tokenBDD);
  }
}
include_once('./inc/header.php');
?>
      <main>
        <div class="flex-col">
          <div id="alpha">
            <?php
            if (isset($_GET['registration'])) {
              if ($_GET['registration'] == 'success') {
                ?><p class="success">Votre inscription a été validée !</p><?php
              }
              else {
                header('Location: ./index.php');
              }
            }
            if (isset($_GET['modifpassword'])) {
              if ($_GET['modifpassword'] == 'success') {
                ?><p class="success">Votre mot de passe a été changé !</p><?php
              }
              else {
                header('Location: ./index.php');
              }
            }
            ?>
          </div>
          <div id="beta">
            <form class="main login" action="" method="post">
              <h1>Demander un nouveau mot de passe :</h1>
              <?php
              if (isset($_GET['recovery']) && $_GET['recovery'] == 'true') { ?>
                <p>Un email de récupération de mot de passe vous a été envoyé. Veuillez consulter votre boite mail.</p><?php
              }
              else {
                //Input pour l'email
                nouvelInputSQL($textLabel='Votre email',$typeInput='email',$nomInput='mail',$placeholder='Ex: jean.dupont@gmail.com',$errors);
                //Input submit
                inputSubmit();
              }
              ?>
            </form>
          </div>
        </div>
      </main>
<?php
include_once('./inc/footer.php');
?>
