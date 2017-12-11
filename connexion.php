<?php
$title = 'Connexion';
// include_once('./inc/pdo.php');
// include_once('./inc/fonctions.php');
// session_start();
include_once('./cookies.php');
global $pdo;
ifIs_logged($location='index');
$errors = array();
if(!empty($_POST['submitted'])) {

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
	        		if(!empty($_POST['stayLog'])) {
	        			// création d'un cookies qui dure 5 jour
	                 setcookie('userck', $user['id']. '---' . sha1($user['username'].$user['password'].$_SERVER['REMOTE_ADDR']) , time() + 3600 * 24 * 5,'/', 'localhost', false, true);

	        		}

	        		$_SESSION['user'] = array(
	        			'id'     => $user['id'],
	        			'pseudo' => $user['username'],
	        			'role'   => $user['role'],
	        			'ip'     => $_SERVER['REMOTE_ADDR'],

	        		);
							include_once('./cookies.php');
	        		header('Location: index.php');

	        	}
            else {
	        		$errors['password'] = 'password invalide.';
	        	}
	        }
	}

}

include_once('./inc/header.php');
?>
  <form method="POST" action="connexion.php" id="formconnexion" class="main login">
		<?php nouvelInputSQL($textLabel='pseudo',$typeInput='text',$nomInput='pseudo',$placeholder='pseudo',$errors);
		nouvelInputSQL($textLabel='Entrez votre mot de passe',$typeInput='password',$nomInput='password',$placeholder='Votre mot de passe',$errors); ?>
		<div class="checkbox">
			<div class="label"></div>
			<div class="input">
				<label for="stayLog">Se souvenir de moi</label>
				<input type="checkbox" name="stayLog" />
			</div>
		</div><?php
		inputSubmit() ?>
		<div class="mdpOublie">
			<div class="label"></div>
			<a href="./forgotten-password.php"><p>Mot de passe oublié ?</p></a>
		</div>
  </form>



<?php
include_once('./inc/footer.php');
?>
