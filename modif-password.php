<?php
$title = 'Modifier le mot de passe';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php');
global $pdo;
ifIs_logged($location='index');
$errors = array();
$success = false;
//Vérifier que le mail et le token correspondent
if (isset($_GET['mail']) && !empty($_GET['mail']) && isset($_GET['token']) && !empty($_GET['token'])) {
  $mail = urldecode($_GET['mail']);
  $token = $_GET['token'];
  //Ici les requêtes
    //Déclaration de la requêteVerifUserExist
    $sqlVerifUserExist = "SELECT username FROM users WHERE 1=1 AND email= :mail AND token= :token";
    //Préparation de la requêteVerifUserExist
    $queryVerifUserExist = $pdo->prepare($sqlVerifUserExist);
    //Protection contre les injections SQL
    $queryVerifUserExist->bindValue(':mail',$mail,PDO::PARAM_STR);
    $queryVerifUserExist->bindValue(':token',$token,PDO::PARAM_STR);
    //Exécution de la requêteVerifUserExist
    $queryVerifUserExist->execute();
    $verifUserExist = $queryVerifUserExist->fetchColumn();
  //Fin des requêtes
  if (empty($verifUserExist)) {
    header('Location: ./index.php?error=true');
  }
}
else {
  header('Location: ./index.php?error=true');
}
if (!empty($_POST['submitted'])) {
  //Se protéger contre les failles XSS (retire les balises qui pourraient être soumises dans les champs) grace à strip_tags()
  //Supprimer les espaces avant ou après avec trim()
  $mdp1 = trim(strip_tags($_POST['mdp1']));
  $mdp2 = trim(strip_tags($_POST['mdp2']));
  //Vérifier que le premier et le second mot de passe sont fournis
  if (!empty($mdp1) && !empty($mdp2)) {
    // Vérifier que le second mot de passe est le même que le premier
    if ($mdp1 != $mdp2) {
      $errors['mdp2'] = 'Ce mot de passe doit être identique au premier.';
    } else {
      //Vérifier que mdp1 est fourni et a entre x et y caractères
      $errors = inputCorrect($mdp1,'mdp1',$errors,6,255);
    }
  } else {
    $errors['mdp1'] = 'Veuillez renseigner ce champ';
    $errors['mdp2'] = 'Veuillez renseigner ce champ';
  }
  //Vérifier que tout est correct
  if (count($errors) == 0) {
    $success = true;
    //Génération du token
    $listecara = 'abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890';
    $token = substr(str_shuffle($listecara),2,68);
    //hashage du password
    $hashpassword = password_hash($mdp1,PASSWORD_BCRYPT);
    //On update le password
    //Ici les requêtes
      //Déclaration de la requêteUpdatePassword
      $sqlUpdatePassword = "UPDATE users SET password=:hashpassword , token=:token WHERE username=:verifUserExist";
      //Préparation de la requêteUpdatePassword
      $queryUpdatePassword = $pdo->prepare($sqlUpdatePassword);
      //Protection contre les injections SQL
      $queryUpdatePassword->bindValue(':hashpassword',$hashpassword,PDO::PARAM_STR);
      $queryUpdatePassword->bindValue(':token',$token,PDO::PARAM_STR);
      $queryUpdatePassword->bindValue(':verifUserExist',$verifUserExist,PDO::PARAM_STR);
      //Exécution de la requêteUpdatePassword
      $queryUpdatePassword->execute();
    //Fin des requêtes
    header('Location: ./login.php?modifpassword=success');
  }
}
include_once('./inc/header.php');
?>
      <main>
        <div class="flex-col">
          <div id="alpha">
            <?php
            // echo $verifUserExist;
            ?>
          </div>
          <div id="beta">
            <form class="main login" action="" method="post">
              <h1>Réinitialisation de votre mot de passe, <?php echo $verifUserExist; ?> :</h1>
              <?php
              //Input pour le mdp1
              nouvelInputSQL($textLabel='Entrez votre nouveau mot de passe',$typeInput='password',$nomInput='mdp1',$placeholder='Nouveau mot de passe',$errors);
              //Input pour le mdp2
              nouvelInputSQL($textLabel='Confirmez le mot de passe',$typeInput='password',$nomInput='mdp2',$placeholder='Mot de passe',$errors);
              //Input submit
              inputSubmit();
              ?>
            </form>
          </div>
        </div>
      </main>
<?php
include_once('./inc/footer.php');
?>
