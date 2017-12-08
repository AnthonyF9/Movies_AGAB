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
?>
