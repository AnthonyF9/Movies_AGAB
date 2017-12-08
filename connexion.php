<?php
include_once('./inc/pdo.php');
include_once('./inc/fonctions.php');
session_start();
ifIs_logged($location='index');
$title = 'Connexion';
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

include_once('./inc/header.php');
?>
  <form method="POST" action="connexion.php" id="formconnexion">
    <div class="form-group">
			<label for="pseudo">Pseudo ou mail<span>*</span></label>
      <p class="error"><?php if(!empty($errors['pseudo'])) { echo $errors['pseudo']; } ?></p>
			<?php nouvelInputSQL($textLabel='pseudo',$typeInput='text',$nomInput='pseudo',$placeholder='pseudo',$errors); ?>
    </div>

		<?php nouvelInputSQL($textLabel='Entrez votre mot de passe',$typeInput='password',$nomInput='password',$placeholder='Votre mot de passe',$errors) ?>
    <label>
      <input type="checkbox" name="remember" /> Se souvenir de moi
    </label>
    <br/>
    <?php inputSubmit() ?>
	  <a href="passwordforget.php">Mot de passe perdu</a>
  </form>



<?php
include_once('./inc/footer.php');
?>
