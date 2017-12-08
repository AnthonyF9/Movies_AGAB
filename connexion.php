<?php
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
$title = 'Connexion';
$errors = array();


if(!empty($_POST['submitme'])) {

	// protection XSS
	$pseudo    = trim(strip_tags($_POST['pseudo']));
	$password  = trim(strip_tags($_POST['password']));


	if(empty($pseudo)) {
	    $errors['pseudo'] = 'Veuillez indiquer un pseudo.';
	}
	if(empty($password)) {
	    $errors['password'] = 'Veuillez indiquer un password.';
	}
	// Si pas d'erreur => verif  compte existe
	if(count($errors) == 0) {

		// verifier si utilisateur existe et si mot de passe correspond.
		$sqluser = "SELECT * FROM users WHERE username = :pseudo OR email = :pseudo";
	        $smtp = $pdo->prepare($sqluser);
	        $smtp->bindValue(':pseudo',$pseudo);
	        $smtp->execute();
	        $user = $smtp->fetch();

	        if(!$user) {
	           $errors['pseudo'] = 'pseudo invalide.';
	        }
          else {
	        	if(password_verify($password,$user['password'])) {
	        		// if rember est coché
	        		if(!empty($_POST['remember'])) {
	        			// création d'un cookies qui dure 5 jour
	                 setcookie('userck', $user['id']. '---' . sha1($user['pseudo'].$user['password'].$_SERVER['REMOTE_ADDR']) , time() + 3600 * 24 * 5,'/');

	        		}

	        		$_SESSION['user'] = array(
	        			'id'     => $user['id'],
	        			'pseudo' => $user['username'],
	        			'role'   => $user['role'],
	        			'ip'     => $_SERVER['REMOTE_ADDR'],

	        		);

	        		// header('Location: index.php');

	        	}
            else {
	        		$errors['password'] = 'password invalide.';
	        	}
	        }
	}

}




// function nouvelInputSQL($textLabel='pseudo',$typeInput='text',$nomInput='pseudo',$placeholder='pseudo',$errors);
include_once('./inc/header.php');
?>
  <form method="POST" action="connexion.php" id="formconnexion">
    <div class="form-group">
      <label for="pseudo">Pseudo ou mail<span>*</span></label>
      <p class="error"><?php if(!empty($errors['pseudo'])) { echo $errors['pseudo']; } ?></p>
      <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>" />
    </div>
<?php nouvelInputSQL($textLabel='Entrez votre mot de passe',$typeInput='password',$nomInput='password',$placeholder='Votre mot de passe',$errors) ?>

    <label>
      <input type="checkbox" name="remember" /> Se souvenir de moi
    </label>
    <br>

    <?php inputSubmit()
    { ?>
      <div>
    <input type="submit" name="submitme" value="Connexion" class="btn btn-default" />
  </div><?php
}
  </form>
  <a href="passwordforget.php">Mot de passe perdu</a>



<?php
include_once('./inc/footer.php');
?>
