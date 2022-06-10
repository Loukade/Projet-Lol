<?php

$url = 'https://euw1.api.riotgames.com';
$api = new Api();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement</title>
</head>
<body>

<section class="classement">
    <div class="header_classement">
        <div class="header_part iron">
            <a href="index.php?Controleur=Classement&action=afficherIron">  <img src="img/iron.png" class="img_classement " alt=""></a>
        </div>
        <div class="header_part bronze">
            <a href="index.php?Controleur=Classement&action=afficherBronze"> <img src="img/bronze.png" class="img_classement " alt=""></a>
        </div>
        <div class="header_part silver">
            <a href="index.php?Controleur=Classement&action=afficherSilver">  <img src="img/silver.png" class="img_classement " alt=""></a>
        </div>
        <div class="header_part gold">
            <a href="index.php?Controleur=Classement&action=afficherGold"> <img src="img/gold.png" class="img_classement " alt=""></a>
        </div>
        <div class="header_part platine">
            <a href="index.php?Controleur=Classement&action=afficherPlatine">  <img src="img/platine.png" class="img_classement " alt=""></a>
        </div>
        <div class="header_part diamond">
            <a href="index.php?Controleur=Classement&action=afficherDiamant"><img src="img/diamond.png"
                                                                                  class="img_classement " alt=""></a>
        </div>
        <div class="header_part master">
            <a href="index.php?Controleur=Classement&action=afficherMaster">  <img src="img/master.png" class="img_classement " alt=""></a>
        </div>
        <div class="header_part grandmaster">
            <a href="index.php?Controleur=Classement&action=afficherGrandmaster">   <img src="img/grandmaster.png" class="img_classement " alt=""></a>
        </div>
        <div class="header_part challenger">
            <a href="index.php?Controleur=Classement&action=afficherChallenger">  <img src="img/challenger.png" class="img_classement " alt=""> </a>
        </div>
    </div>


    <?php if ($_REQUEST['action'] == "afficherDiamant")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/DIAMOND/I";
        elseif ($_REQUEST['action'] == "afficherPlatine")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/PLATINUM/I";
        elseif ($_REQUEST['action'] == "afficherGold")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/GOLD/I";
        elseif ($_REQUEST['action'] == "afficherSilver")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/SILVER/I";
        elseif ($_REQUEST['action'] == "afficherBronze")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/BRONZE/I";
        elseif ($_REQUEST['action'] == "afficherChallenger")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/CHALLENGER/I";
        elseif ($_REQUEST['action'] == "afficherMaster")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/MASTER/I";
        elseif ($_REQUEST['action'] == "afficherGrandmaster")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/GRANDMASTER/I";
        elseif ($_REQUEST['action'] == "afficherClassement")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/CHALLENGER/I";
        elseif ($_REQUEST['action'] == "afficherIron")
            $classement = $url . "/lol/league-exp/v4/entries/RANKED_SOLO_5x5/IRON/I";

    $dataClassement = $api->requestApi($classement, 'GET', '', '');
    ?> <div class="mainframe">
        <div class="best_player_title"><?= $dataClassement[0]['tier'] ?></div>
        <?php

        function fonctionComparaison($a, $b){
            return $a['leaguePoints'] < $b['leaguePoints'];
}

        usort($dataClassement, "fonctionComparaison");

    for ($i = 0; $i < 50; $i++) {
        ;
        $classement = $dataClassement[$i];
        $classement['tier'] = strtolower($classement['tier']);

        ?>


            <div class="barre">
                <div class="barre_inbetween"></div>
            </div>
            <div class="content_classement">
                <div class="player_classement">
                    <div class="ranked"> <?= $i+1 ?>#</div>
                    <div class="username"><img src="img/<?= $classement['tier'] ?>.png" class="icon_summoner"><?= $classement['summonerName'] ?></div>
                    <div class="points"> <?= $classement['leaguePoints'] ?> LP <?php if(isset($classement['miniSeries'])){

                            $classement['miniSeries']['progress'] = str_replace('L', '❌', $classement['miniSeries']['progress']);
                            $classement['miniSeries']['progress'] = str_replace('W', '✔️', $classement['miniSeries']['progress']);
                            $classement['miniSeries']['progress'] = str_replace('N', '-', $classement['miniSeries']['progress']);
                        echo $classement['miniSeries']['progress'];

                        }?> </div>
                    <div class="point_perso">Victoire&nbsp;:&nbsp;<?= $classement['wins']?>  Défaite&nbsp;:&nbsp;<?= $classement['losses']?></div>
                </div>
            </div>
    <?php } ?>
        </div>
</section>
</body>
</html>