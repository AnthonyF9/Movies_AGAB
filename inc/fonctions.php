<?php
// session_start();
function debug($array) {
  echo '<pre>';
  print_r($array);
  echo '</pre>';
}
function br() {
  echo '<br/>';
}
function inputCorrect($title,$titreErrors,$errors,$caraMin,$caraMax)
{
  if (!empty($title)) {
    if (strlen($title) < $caraMin) {
      $errors[$titreErrors] = 'Veuillez mettre plus de ' . $caraMin . ' caractères';
    }
    elseif (strlen($title) > $caraMax) {
      $errors[$titreErrors] = 'Veuillez mettre moins de ' . $caraMax .' caractères';
    }
  } else {
    $errors[$titreErrors] = 'Veuillez renseigner ce champ';
  }
  return $errors;
}
function nouvelInputSQL($textLabel='Titre',$typeInput='text',$nomInput='title',$placeholder='Titre',$errors)
{ ?>
  <div>
    <label class="label" for="<?php echo $nomInput ?>"><?php echo $textLabel ?> <span class="erreur">*</span> : </label>
    <input class="input" type="<?php echo $typeInput ?>" name="<?php echo $nomInput ?>" placeholder="<?php echo $placeholder ?>" value="<?php if(!empty($_POST[$nomInput])) { echo $_POST[$nomInput]; } ?>">
  </div>
  <div class="erreur pform">
    <label class="label"></label>
    <?php if (!empty($errors[$nomInput])) { echo $errors[$nomInput]; } ?>
  </div><?php
}
function nouvelInputSQL2($textLabel='Titre',$typeInput='text',$nomInput='title',$placeholder='Titre',$errors)
{ ?>
  <div>
    <label class="label" for="<?php echo $nomInput ?>"><?php echo $textLabel ?> : </label>
    <input class="input" type="<?php echo $typeInput ?>" name="<?php echo $nomInput ?>" placeholder="<?php echo $placeholder ?>" value="<?php if(!empty($_POST[$nomInput])) { echo $_POST[$nomInput]; } ?>">
  </div>
  <div class="erreur pform">
    <label class="label"></label>
    <?php if (!empty($errors[$nomInput])) { echo $errors[$nomInput]; } ?>
  </div><?php
}
function nouvelInputSQLget($textLabel='Titre',$typeInput='text',$nomInput='title',$placeholder='Titre',$errors)
{ ?>
  <div>
    <label class="label" for="<?php echo $nomInput ?>"><?php echo $textLabel ?> : </label>
    <input class="input" type="<?php echo $typeInput ?>" name="<?php echo $nomInput ?>" placeholder="<?php echo $placeholder ?>" value="<?php if(!empty($_GET[$nomInput])) { echo $_GET[$nomInput]; } ?>">
  </div>
  <div class="erreur pform">
    <label class="label"></label>
    <?php if (!empty($errors[$nomInput])) { echo $errors[$nomInput]; } ?>
  </div><?php
}
function nouveauTextareaSQL($textLabel='Titre',$nomTextarea='title',$placeholder='Titre',$errors)
{ ?>
  <div>
    <label class="label" for="<?php echo $nomTextarea ?>"><?php echo $textLabel ?> <span class="erreur">*</span> : </label>
    <textarea class="input" name="<?php echo $nomTextarea ?>" rows="8" cols="10" placeholder="<?php echo $placeholder ?>"><?php if(!empty($_POST[$nomTextarea])) { echo $_POST[$nomTextarea];} ?></textarea>
  </div>
  <div class="erreur pform">
    <?php if (!empty($errors[$nomTextarea])) { echo $errors[$nomTextarea];} ?>
  </div><?php
}
function inputSubmit()
{ ?>
  <div>
    <label class="label" for="submitted"></label>
    <input class="input" type="submit" name="submitted" value="Valider">
  </div><?php
}
function nouveauSelect($textLabel='Titre',$nomSelect='title',$placeholder='.........',$errors,$nomTableauSource)
{ ?>
  <div>
    <label class="label" for="<?php echo $nomSelect ?>"><?php echo $textLabel ?> <span class="erreur">*</span> : </label>
    <select name="<?php echo $nomSelect ?>">
      <option value=""><?php echo $placeholder ?></option>
      <?php foreach ($nomTableauSource as $key => $value) { ?>
        <option <?php if(!empty($_POST[$nomSelect])) { if($value == $_POST[$nomSelect]) { echo 'selected="selected" ';}} ?> value="<?php echo $value; ?>"><?php echo $value; ?>
        </option>
      <?php } ?>
    </select>
  </div>
  <div class="erreur pform">
    <?php
      if (!empty($errors[$nomSelect])) {
        echo $errors[$nomSelect];
      }
    ?>
  </div><?php
}
function nouveauSelect2($textLabel='Titre',$nomSelect='title',$placeholder='.........',$errors,$nomTableauSource)
{ ?>
  <div>
    <label class="label" for="<?php echo $nomSelect ?>"><?php echo $textLabel ?> : </label>
    <select name="<?php echo $nomSelect ?>">
      <option value=""><?php echo $placeholder ?></option>
      <?php foreach ($nomTableauSource as $key => $value) { ?>
        <option <?php if(!empty($_POST[$nomSelect])) { if($value == $_POST[$nomSelect]) { echo 'selected="selected" ';}} ?> value="<?php echo $value; ?>"><?php echo $value; ?>
        </option>
      <?php } ?>
    </select>
  </div>
  <div class="erreur pform">
    <?php
      if (!empty($errors[$nomSelect])) {
        echo $errors[$nomSelect];
      }
    ?>
  </div><?php
}
function getAllArticles($order = 'created_at',$orderby = 'DESC',$limit = 'all',$nomSelection)
{
  global $pdo;
  if($limit == 'all') {
    $sqlS = "SELECT * FROM articles ORDER BY $order $orderby";
  }
  elseif(is_numeric($limit)) {
    $sqlS = "SELECT * FROM articles ORDER BY $order $orderby LIMIT $limit";
  }
  else {
    return 'no';
  }
  $queryS = $pdo->prepare($sqlS);
  $queryS->execute();
  $nomSelection = $queryS->fetchAll();
  return $nomSelection;
}
function is_logged()
{
  if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']) && !empty($_SESSION['user']['pseudo']) && !empty($_SESSION['user']['role']) && !empty($_SESSION['user']['ip'])) {
    $ip= $_SERVER["REMOTE_ADDR"];
    if ($ip == $_SESSION['user']['ip']) {
      return true;
    }
  }
  return false;
}
function is_admin()
{
  if (!empty($_SESSION['user']) && !empty($_SESSION['user']['id']) && !empty($_SESSION['user']['pseudo']) && !empty($_SESSION['user']['role']) && !empty($_SESSION['user']['ip'])) {
    $ip= $_SERVER["REMOTE_ADDR"];
    if ($ip == $_SESSION['user']['ip'] && $_SESSION['user']['role'] == 'admin') {
      return true;
    }
  }
  return false;
}
function ifIs_logged($location='index')
{
  if (is_logged() == true) {
    header('Location: ./' . $location . '.php');
  }
}
function single_affiche($movie)
{
  $image = $movie['id'];
  $alt = $movie['title'];
  if (file_exists('posters/'.$image.'.jpg')) {
    $return = '<div class="img"><img src="posters/'.$image.'.jpg" alt="'.$alt.'"></div>';
  } else {
    $return = '<div class="img" class="sansimage"><p class="introuvable">poster introuvable<p></div>';
  }
  return $return;
}
function list_affiche($movie,$index1,$index2,$index3)
{
  $image = $movie[$index1];
  $alt = $movie[$index2];
  $link = $movie[$index3];

  if (file_exists('posters/'.$image.'.jpg')) {
    $return = '<div class="img"><a href="details.php?movie='.$link.'"><img src="posters/'.$image.'.jpg" alt="'.$alt.'"></a></div>';
  } else {
    $return = '<div class="img" class="sansimage"><a class="introuvable" href="details.php?movie='.$link.'">poster introuvable</a></div>';
  }
  return $return;
}
function paginationIndex($page,$nbPages,$file)
{
  if ($page < 0 || $page > $nbPages) {
    header('Location: ./' . $file . '.php');
  } ?>
  <div>
    <?php
      if($page-1 > 0) {
        ?><a href="<?php echo $file ?>.php?page=<?php echo $page-1; ?>"><button class="alignVertical" type="button" name="button">Page précédente</button></a><?php
      } ?>
  </div>
  <div>
    <p>Page <?php echo $page ?> sur <?php echo $nbPages ?></p>
    <div>
      <form class="" action="" method="post">
        <p>
          <?php
          if(!empty($_POST['submit'])) {
            header('Location: ./'. $file .'.php?page='.$_POST['navpage']);
          }
          ?>
          <label class="label" for="navpage">Aller à la page</label>
          <input class="input allerAPage" type="number" name="navpage" value="<?php if(!empty($_POST['navpage'])) { echo $_POST['navpage'];} ?>" />
          <label class="label" for="submitted"></label>
          <input class="input" type="submit" name="submit" value="Go">
      </form>
    </div>
  </div>
  <div>
    <?php if($page+1 <= $nbPages) {
      ?><a href="<?php echo $file ?>.php?page=<?php echo $page+1; ?>"><button class="alignVertical" type="button" name="button">Page suivante</button></a><?php
    } ?>
  </div>
  <?php
}
?>
