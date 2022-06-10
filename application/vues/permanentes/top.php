<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php

  if(isset($_REQUEST['Controleur'])){
    if($_REQUEST['action'] == "afficherSummoner" || $_REQUEST['action'] == "afficherDetailSummoner" ){ ?>
        <link rel="stylesheet" href="css/style.css">
    <?php }elseif($_REQUEST['action'] == "afficherChampion" || $_REQUEST['action'] == "afficherChampionDetail" ){ ?>
    <link rel="stylesheet" href="css/style_champ.css">
    <?php } elseif($_REQUEST['Controleur'] == "Classement"){
?>
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
  <style>
  header{
    display: flex;
    width: 100%;
    padding-top: 16px;
    padding-bottom: 16px;
    background-color: #111;
    color: white;
    align-items: center;
}
.logos{
    width: 15%;
    padding-left:5%
}
a{
    text-decoration: none;
    color: white;
}
ol{
    display: flex;
    list-style:none;
    position: absolute;
    right:3%;
}
li{
    padding: 10px;
    padding-right:5%;
    font-size:120%;
}
footer{
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    padding-top: 32px;
    padding-bottom: 32px;
    background-color: #1e1e1e;
    color: white;
}
h2{
    font-size: 130%;
}
</style>
<header>
    <img src="img/logos.png" class="logos" alt="">
    <ol>
        <?php ?>

        <li><a href="index.php?Controleur=Affichage&action=afficherSummoner">Accueil</a></li>
        <li><a href="index.php?Controleur=Affichage&action=afficherChampion">Champion</a></li>
        <li><a href="index.php?Controleur=Classement&action=afficherClassement">Classement</a></li>
    </ol>
</header>
