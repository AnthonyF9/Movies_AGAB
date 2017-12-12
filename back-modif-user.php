<?php
$title = 'Modifier les informations d\'un utilisateur de Movies AGAB';
include_once('./cookies.php'); // pdo, session start et fonctions inside
if (is_admin() == true) {

}
else {
  header('Location: ./index.php');
}
$errors = array();
$success = false;
if (!empty($_GET['token'])) {
  $token = $_GET['token'];
  $sql = "SELECT * FROM users WHERE token = :token";
  $query = $pdo->prepare($sql);
  $query->bindValue(':token',$token,PDO::PARAM_STR);
  $query->execute();
  $user = $query->fetch();
  if(empty($user)) {
    header('Location: ./dashboard.php');
  } else {
    if (!empty($_POST['submitted'])) {
      //Se protéger contre les failles XSS (retire les balises qui pourraient être soumises dans les champs) grace à strip_tags()
      //Supprimer les espaces avant ou après avec trim()
      $pseudo = trim(strip_tags($_POST['pseudo']));
      $mail = trim(strip_tags($_POST['mail']));
      $role = trim(strip_tags($_POST['role']));
      if (!empty($pseudo)) {
        if (strlen($pseudo) < 3) {
          $errors['pseudo'] = 'Veuillez mettre plus de 3 caractères';
        }
        elseif (strlen($pseudo) > 100) {
          $errors['pseudo'] = 'Veuillez mettre moins de 150 caractères';
        }
        else {
          //Vérifier que le pseudo n'existe pas déjà
          //Ici les requêtes
            //Déclaration de la requêtepseudo
            $sqlPseudo = "SELECT username FROM users WHERE token != :token";
            //Préparation de la requêtepseudo
            $queryPseudo = $pdo->prepare($sqlPseudo);
            //Protection contre les injections SQL
            $queryPseudo->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
            $query->bindValue(':token',$token,PDO::PARAM_STR);
            //Exécution de la requêtepseudo
            $queryPseudo->execute();
            $pseudoBDD = $queryPseudo->fetch();
          //Fin des requêtes
          if (!empty($pseudoBDD) && $pseudoBDD == $user['username']) {
            $errors['pseudo'] = 'Ce pseudo existe déjà. Veuillez en choisir un autre.';
          }
        }
      } else {
        $errors['pseudo'] = 'Veuillez renseigner ce champ';
      }
      if (!empty($mail)) {
        // Vérifier que le mail est bien un mail
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
          //Vérifier que le mail n'existe pas déjà
          //Ici les requêtes
            //Déclaration de la requêtemail
            $sqlMail = "SELECT email FROM users WHERE token != :token";
            //Préparation de la requêtemail
            $queryMail = $pdo->prepare($sqlMail);
            //Protection contre les injections SQL
            $queryMail->bindValue(':mail',$mail,PDO::PARAM_STR);;
            $query->bindValue(':token',$token,PDO::PARAM_STR);
            //Exécution de la requêtemail
            $queryMail->execute();
            $mailBDD = $queryMail->fetch();
          //Fin des requêtes
          if (!empty($mailBDD) && $mailBDD == $user['email']) {
            $errors['mail'] = 'Ce mail est déjà pris.';
          }
        }
        else {
          $errors['mail'] = 'Ce que vous avez renseigné (' . $mail . ') n\'est pas un email valide. Veuillez saisir un mail valide.';
        }
      } else {
        $errors['mail'] = 'Veuillez renseigner ce champ';
      }
      if (!empty($_POST['role'])) {

      } else {
        $errors['role'] = 'Veuillez renseigner ce champ';
      }
      //Vérifier que tout est correct
      if (count($errors) == 0) {
        $success = true;
        // echo 'Bravo';
        //Ici les requêtes
          //Déclaration de la requête0
          $sql = "UPDATE users SET username=:pseudo,email=:mail,role=:role WHERE token=:token";
          //Préparation de la requête0
          $query = $pdo->prepare($sql);
          //Protection contre les injections SQL
          $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
          $query->bindValue(':mail',$mail,PDO::PARAM_STR);
          $query->bindValue(':role',$role,PDO::PARAM_STR);
          $query->bindValue(':token',$token,PDO::PARAM_STR);
          //Exécution de la requête0
          $query->execute();
        //Fin des requêtes
        header('Location: ./back-users.php');
      }
    }
  }
} else {
  header('Location: ./dashboard.php');
}
include_once('./inc/headerback.php');
?>

      <main>
        <div id="delta">
          <h1></h1>
          <?php
            // $token = trim(strip_tags($_GET['token']));
            // $sql = "SELECT * FROM users WHERE 1=1 AND token=:token";
            // $query = $pdo->prepare($sql);
            // $query->bindValue(':token',$token,PDO::PARAM_STR);
            // $query->execute();
            // $user = $query->fetch();
          ?>
          <form class="" action="" method="post">
            <div>
              <label class="label" for="pseudo">Pseudo : </label>
              <input class="input" type="text" name="pseudo" placeholder="Le pseudo" value="<?php
                if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } else { if(!empty($user['username'])) { echo $user['username'];}} ?>">
            </div>
            <div class="erreur pform">
              <?php if (!empty($errors['pseudo'])) { echo $errors['pseudo'];} ?>
            </div>
            <div>
              <label class="label" for="mail">Email : </label>
              <input class="input" type="email" name="mail" placeholder="example@contact.com" value="<?php
                if(!empty($_POST['mail'])) { echo $_POST['mail']; } else { if(!empty($user['username'])) { echo $user['email']; }} ?>">
            </div>
            <div class="erreur pform">
              <?php if (!empty($errors['mail'])) { echo $errors['mail'];} ?>
            </div>
            <div>
              <label class="label" for="role">Rôle : </label>
              <input class="input" type="text" name="role" placeholder="Le rôle" value="<?php
                if(!empty($_POST['role'])) { echo $_POST['role']; } else { if(!empty($user['username'])) { echo $user['role']; }} ?>">
            </div>
            <div class="erreur pform">
              <?php if (!empty($errors['role'])) { echo $errors['role'];} ?>
            </div>
            <?php inputSubmit() ?>
          </form>
        </div>
      </main>

<?php
include_once('./inc/footer.php');
?>
