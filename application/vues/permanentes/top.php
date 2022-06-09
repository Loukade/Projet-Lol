<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <?php
    

  if(isset($_REQUEST['Controleur'])){
    if($_REQUEST['Controleur'] == "" || $_REQUEST['Controleur'] == "Affichage" && $_REQUEST['action'] == "afficherSummoner" || $_REQUEST['Controleur'] == "Affichage" && $_REQUEST['action'] == "afficherDetailSummoner" ){ ?>
        <link rel="stylesheet" href="css/style.css">
    <?php }elseif( $_REQUEST['action'] == "afficherChampion" || $_REQUEST['action'] == "afficherChampionDetail") { ?>
    <link rel="stylesheet" href="css/style_champ.css">
    <?php }
    elseif($_REQUEST['action'] == "afficherClassement"){ ?>
      <link rel="stylesheet" href="css/style_classement.css">
      <?php
    }
  }else{
      ?>
    <link rel="stylesheet" href="css/style.css">
    <?php
  }?>

    <title>LoLAnalist</title>
</head>
<body>
<header>
    <h1>LoLAnalist</h1>
    <ol>
        <?php ?>

        <li><a href="index.php?Controleur=Affichage&action=afficherSummoner">Accueil</a></li>
        <li><a href="index.php?Controleur=Affichage&action=afficherChampion">Champion</a></li>
        <li><a href="index.php?Controleur=Affichage&action=afficherClassement">Classement</a></li>
    </ol>
</header>
