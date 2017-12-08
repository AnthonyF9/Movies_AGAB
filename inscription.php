<?php
$title = 'Inscription';
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
// include_once('./cookies.php');
global $pdo;
ifIs_logged($location='index');
$errors = array();
$success = false;
if (!empty($_POST['submitted'])) {
  //Se protéger contre les failles XSS (retire les balises qui pourraient être soumises dans les champs) grace à strip_tags()
  //Supprimer les espaces avant ou après avec trim()
  $mail = trim(strip_tags($_POST['mail']));
  $pseudo = trim(strip_tags($_POST['pseudo']));
  $password1 = trim(strip_tags($_POST['password1']));
  $password2 = trim(strip_tags($_POST['password2']));
  //Vérifier que pseudo est fourni, a entre x et y caractères et n'existe pas déjà
  if (!empty($pseudo)) {
    if (strlen($pseudo) < 3) {
      $errors['pseudo'] = 'Veuillez mettre plus de 3 caractères';
    }
    elseif (strlen($pseudo) > 150) {
      $errors['pseudo'] = 'Veuillez mettre moins de 150 caractères';
    }
    else {
      //Vérifier que le pseudo n'existe pas déjà
      //Ici les requêtes
        //Déclaration de la requêtepseudo
        $sqlPseudo = "SELECT id FROM users WHERE username = :pseudo";
        //Préparation de la requêtepseudo
        $queryPseudo = $pdo->prepare($sqlPseudo);
        //Protection contre les injections SQL
        $queryPseudo->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
        //Exécution de la requêtepseudo
        $queryPseudo->execute();
        $pseudoBDD = $queryPseudo->fetch();
      //Fin des requêtes
      if (!empty($pseudoBDD)) {
        $errors['pseudo'] = 'Ce pseudo existe déjà. Veuillez en choisir un autre.';
      }
    }
  } else {
    $errors['pseudo'] = 'Veuillez renseigner ce champ';
  }
  //Vérifier qu'un mail est fourni et n'existe pas déjà
  if (!empty($mail)) {
    // Vérifier que le mail est bien un mail
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      //Vérifier que le mail n'existe pas déjà
      //Ici les requêtes
        //Déclaration de la requêtemail
        $sqlMail = "SELECT id FROM users WHERE email=:mail";
        //Préparation de la requêtemail
        $queryMail = $pdo->prepare($sqlMail);
        //Protection contre les injections SQL
        $queryMail->bindValue(':mail',$mail,PDO::PARAM_STR);;
        //Exécution de la requêtemail
        $queryMail->execute();
        $mailBDD = $queryMail->fetch();
      //Fin des requêtes
      if (!empty($mailBDD)) {
        $errors['mail'] = 'Ce mail est déjà pris.';
      }
    }
    else {
      $errors['mail'] = 'Ce que vous avez renseigné (' . $mail . ') n\'est pas un email valide. Veuillez saisir un mail valide.';
    }
  } else {
    $errors['mail'] = 'Veuillez renseigner ce champ';
  }
  //Vérifier que le premier et le second mot de passe sont fournis
  if (!empty($password1) && !empty($password2)) {
    // Vérifier que le second mot de passe est le même que le premier
    if ($password1 != $password2) {
      $errors['password2'] = 'Ce mot de passe doit être identique au premier.';
    } else {
      //Vérifier que password1 est fourni et a entre x et y caractères
      $errors = inputCorrect($password1,'password1',$errors,6,255);
    }
  } else {
    $errors['password1'] = 'Veuillez renseigner ce champ';
    $errors['password2'] = 'Veuillez renseigner ce champ';
  }
  //Vérifier que tout est correct
  if (count($errors) == 0) {
    $success = true;
    //Génération du token
    $listecara = 'abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890abcdefghijklmnopqrstuvwxyzAZERTYUIOPQSDFGHJKLMWXCVBN1234567890';
    $token = substr(str_shuffle($listecara),2,68);
    //hashage du password
    $hashpassword = password_hash($password1,PASSWORD_BCRYPT);
    //Ici les requêtes
      //Déclaration de la requête0
      $sql = "INSERT INTO users(username,email,password,token,created_at,role) VALUES (:pseudo,:mail,:hashpassword,:token,NOW(),'user')";
      //Préparation de la requête0
      $query = $pdo->prepare($sql);
      //Protection contre les injections SQL
      $query->bindValue(':mail',$mail,PDO::PARAM_STR);
      $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
      $query->bindValue(':hashpassword',$hashpassword,PDO::PARAM_STR);
      $query->bindValue(':token',$token,PDO::PARAM_STR);
      //Exécution de la requête0
      $query->execute();
    //Fin des requêtes
    // header('Location: ./login.php?registration=success');
  }
}
include_once('./inc/header.php');
?>
      <main>

            <form action="" method="post" class="main">
              <h1>Inscription :</h1>
              <?php
                //Input pour le pseudo
                nouvelInputSQL($textLabel='Choisissez un pseudo',$typeInput='text',$nomInput='pseudo',$placeholder='Pseudo',$errors);
                //Input pour l'email
                nouvelInputSQL($textLabel='Entrez votre email',$typeInput='email',$nomInput='mail',$placeholder='Ex: jean.dupont@gmail.com',$errors);
                //Input pour le password
                nouvelInputSQL($textLabel='Entrez un mot de passe',$typeInput='password',$nomInput='password1',$placeholder='Votre mot de passe',$errors);
                //Input pour la verif du password
                nouvelInputSQL($textLabel='Entrez à nouveau votre mot de passe',$typeInput='password',$nomInput='password2',$placeholder='Votre mot de passe',$errors);
                //Input submit
                inputSubmit();
                if (count($errors) == 0) { ?><p>Inscription réussie</p><?php }
              ?>
            </form>


      </main>
<?php
include_once('./inc/footer.php');
?>
