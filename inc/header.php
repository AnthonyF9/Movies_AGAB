<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Movies AGAB</title>
    <meta name="description" content="entrainement">
    <meta name="viewport" content="width=width-device, initial scale=1">
    <link rel="stylesheet" href="./assets/css/reset.css" />
    <link rel="stylesheet" href="./assets/css/default.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Monoton" rel="stylesheet">
  </head>
  <body>
    <div id="wrapper">
      <header>
        <div>
          <h1><a href="./index.php">Movies AGAB</a></h1>
          <nav>
            <ul>
              <li><a href="./index.php">Accueil</a></li>
              <?php
              if (is_admin() == true) { ?>
                <li><a href="./a-voir.php">Votre liste</a></li>
                <li><a href="./dashboard.php">Panneau de contrôle</a></li>
                <li><span>Bonjour <?php echo $_SESSION['user']['pseudo'] ?></span></li>
                <li><span><a href="./index.php?log=out">Se déconnecter</a></span></li><?php
              }
              elseif (is_logged() == true) { ?>
                <li><a href="./a-voir.php">Votre liste</a></li>
                <li><span class="hello">Bonjour <?php echo $_SESSION['user']['pseudo'] ?></span></li>
                <li><span><a href="./index.php?log=out">Se déconnecter</a></span></li><?php
              }
              else { ?>
                <li><a href="./inscription.php">Inscription</a></li>
                <li><a href="./connexion.php">Se connecter</a></li><?php
              }
              ?>
            </ul>
          </nav>
        </div>
      </header>
