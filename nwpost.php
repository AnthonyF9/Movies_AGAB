<?php // add.php
	// Connexion à la base de donnée
    include('inc/pdo.php');
    //initialise la variable contenant les messages d'erreurs à... rien
    $error = array();
    //si le formulaire est soumis
    if ( !empty($_POST['submitid']) ) {
          // echo 'formulaire soumis';

        // Protection XSS
        $title = trim(strip_tags($_POST['title']));
        // echo $title;
        $year = trim(strip_tags($_POST['year']));
        // echo $year;
        $rating = trim(strip_tags($_POST['rating']));
        // echo $rating;
        $genres = trim(strip_tags($_POST['genres']));
        // echo $genres;


        //verification titre du film
        if (!empty($title)){
            if(strlen($title) < 3 ) {
				      $error['title'] ;
      			} elseif(strlen($title) > 40) {
      				$error['title'] = 'Votre nom est trop long.';
      			}
        } else {
        	$error['title'] = 'Veuillez entrer votre titre du film';
        }

        //verification de l'année
        if (!empty($year)){
            if(strlen($year) < 3 ) {
				$error['year'] = 'Votre nom est trop court. (minimum 3 caractères)';
			} elseif(strlen($year) > 220) {
				$error['year'] = 'l\'\année est trop long.';
			}

        } else {
        	$error['year'] = 'Veuillez renseigner l\'\année du film';
        }
        //verification de évaluation
        if (!empty($rating)){
            if(strlen($rating) < 3 ) {
        $error['rating'] = 'Votre note est trop juste. (minimum 3 caractères)';
      } elseif(strlen($rating) > ) {
        $error['rating'] = 'Votre note est trop longue.';
      }

        } else {
          $error['rating'] = 'Veuillez noter le film';
        }

        //verification du genres du film
        if (!empty($genres)){
            if(strlen($genres) < 3 ) {
              $error['genres'] ;
            } elseif(strlen($genres) > 40) {
              $error['genres'] = 'le genre du film est trop long.';
            }
        } else {
          $error['genres'] = 'Veuillez entrer le genre du film';
        }

        // Si aucune error
        if (count($error) == 0){

          $status = 'publier';
            $sql = "INSERT INTO all_movies (title ,year ,rating, genres , created , modified ) VALUES (:title, :year,:rating, :actions,NOW(),NOW())";
            // preparation de la requête
            $stmt = $pdo->prepare($sql);

            // Protection injections SQL
            $stmt->bindValue(':title',$title, PDO::PARAM_STR);
            $stmt->bindValue(':year',$year, PDO::PARAM_STR);
            $stmt->bindValue(':rating',$auteur, PDO::PARAM_STR);
            $stmt->bindValue(':actions',$actions, PDO::PARAM_STR);



            // execution de la requête preparé
            $stmt->execute();
            // redirection vers page accueil
             header("Location: dashboard.php");
             die;
        }

    }

// ?>

<?php include('inc/pdo.php'); ?>

<?php include('inc/header.php'); ?>
    <h1>Formulaire</h1>
<form action="" method="POST">
  <div class="form-group">
      <label for="titre">Titre*</label>
      <span class="error"><?php if(!empty($error['titre'])) { echo $error['titre']; } ?></span>
      <input type="text" name="titre" id="titre" class="form-control" value="<?php if(!empty($_POST['titre'])) { echo $_POST['titre']; } ?>" />
    </div>

    <div class="form-group">
      <label for="Content">Content*</label>
      <span class="error"><?php if(!empty($error['content'])) { echo $error['content']; } ?></span>
      <textarea name="content" id="content" rows="8" cols="80"><?php if(!empty($_POST['content'])) { echo $_POST['content']; } ?></textarea>
    </div>

    <div class="form-group">
      <label for="auteur">Auteur*</label>
      <span class="error"><?php if(!empty($error['auteur'])) { echo $error['auteur']; } ?></span>
      <input type="text" name="auteur" id="auteur" class="form-control" value="<?php if(!empty($_POST['auteur'])) { echo $_POST['auteur']; } ?>" />
    </div>

    <input type="submit" name="submitid" class="btn btn-primary" value="Ajouter" />

</form>


<?php include('inc/footer.php'); ?>
