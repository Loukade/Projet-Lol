<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style_permanent.css">
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

    <?php
  if(isset($_REQUEST['Controleur'])){
    if($_REQUEST['action'] == "afficherSummoner" || $_REQUEST['action'] == "afficherDetailSummoner" ){ ?>
        <link rel="stylesheet" href="/css/style.css">
    <?php }elseif($_REQUEST['action'] == "afficherChampion" || $_REQUEST['action'] == "afficherChampionDetail" ){ ?>
    <link rel="stylesheet" href="/css/style_champ.css">
    <?php } elseif($_REQUEST['Controleur'] == "Classement"){
?>
        <link rel="stylesheet" href="/css/style_classement.css">
        <?php
    }
  }else{
      ?>
    <link rel="stylesheet" href="/css/style.css">
    <?php
  }?>

    <title>GoLol</title>
</head>
<header>
    <img src="/img/logos.png" class="logos" alt="">
    <ol>

        <li><a href="/Accueil">Accueil</a></li>
        <li><a href="/Champion">Champion</a></li>
        <li><a href="/Classement">Classement</a></li>
    </ol>
</header>
