<?php
$Api = new Api();
$europeApi = 'https://europe.api.riotgames.com';
$nomGame = $_GET['game'];
$matchLolById = $europeApi . '/lol/match/v5/matches/' . $nomGame;
$matchLolByGames = $Api->requestApi($matchLolById, 'GET', '', '');
$versions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
$versions = json_decode($versions, true);
$latest = $versions['0'];
$killRed = $matchLolByGames['info']['participants'][0]['kills'] + $matchLolByGames['info']['participants'][1]['kills'] +
    $matchLolByGames['info']['participants'][2]['kills'] + $matchLolByGames['info']['participants'][3]['kills'] + $matchLolByGames['info']['participants'][4]['kills'];
$killBlue = $matchLolByGames['info']['participants'][5]['kills'] + $matchLolByGames['info']['participants'][6]['kills'] + $matchLolByGames['info']['participants'][7]['kills']
    + $matchLolByGames['info']['participants'][8]['kills'] + $matchLolByGames['info']['participants'][9]['kills'];

$deathRed = $matchLolByGames['info']['participants'][0]['deaths'] + $matchLolByGames['info']['participants'][1]['deaths']
    + $matchLolByGames['info']['participants'][2]['deaths'] + $matchLolByGames['info']['participants'][3]['deaths'] + $matchLolByGames['info']['participants'][4]['deaths'];
$deathBlue = $matchLolByGames['info']['participants'][5]['deaths'] + $matchLolByGames['info']['participants'][6]['deaths'] +
    $matchLolByGames['info']['participants'][7]['deaths'] + $matchLolByGames['info']['participants'][8]['deaths'] + $matchLolByGames['info']['participants'][9]['deaths'];

$assistRed = $matchLolByGames['info']['participants'][0]['assists'] + $matchLolByGames['info']['participants'][1]['assists'] +
    $matchLolByGames['info']['participants'][2]['assists'] + $matchLolByGames['info']['participants'][3]['assists'] + $matchLolByGames['info']['participants'][4]['assists'];

$assistBlue = $matchLolByGames['info']['participants'][5]['assists'] + $matchLolByGames['info']['participants'][6]['assists'] + $matchLolByGames['info']['participants'][7]['assists']
    + $matchLolByGames['info']['participants'][8]['assists'] + $matchLolByGames['info']['participants'][9]['assists'];

$goldRed = $matchLolByGames['info']['participants'][0]['goldEarned'] + $matchLolByGames['info']['participants'][1]['goldEarned'] +
    $matchLolByGames['info']['participants'][2]['goldEarned'] + $matchLolByGames['info']['participants'][3]['goldEarned'] + $matchLolByGames['info']['participants'][4]['goldEarned'];

$goldBlue = $matchLolByGames['info']['participants'][5]['goldEarned'] + $matchLolByGames['info']['participants'][6]['goldEarned'] +
    $matchLolByGames['info']['participants'][7]['goldEarned'] + $matchLolByGames['info']['participants'][8]['goldEarned'] + $matchLolByGames['info']['participants'][9]['goldEarned'];


function getChampionInfo($id = 1)
{
    $versions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
    $versions = json_decode($versions, true);
    $latest = $versions['0'];
    $json = file_get_contents('https://ddragon.leagueoflegends.com/cdn/' . $latest . '/data/fr_FR/champion.json');
    $json = json_decode($json, true);
    $list = $json['data'];

    foreach ($list as $key => $value) {
        if ($list[$key]['key'] == $id) {
            return $list[$key];
        }
    }
    return false;
}
function getRunesInfo($id = 1 , $id2 = 1)
{
    $versions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
    $versions = json_decode($versions, true);
    $latest = $versions['0'];
    $json = file_get_contents('https://ddragon.leagueoflegends.com/cdn/' . $latest . '/data/fr_FR/runesReforged.json');
    $json = json_decode($json, true);
    $list = $json;

    foreach ($list as $key => $value) {
        if ($list[$key]['id'] == $id) {
            foreach ($list[$key]['slots'] as $key2 => $value2) {
                    foreach ($list[$key]['slots'][$key2]['runes'] as $key3 => $value3) {
                        if ($list[$key]['slots'][$key2]['runes'][$key3]['id'] == $id2) {
                            return $list[$key]['slots'][$key2]['runes'][$key3];
                        }
                    }
            }
        }
    }

}
function getSummonerSpellInfo($id = 1)
{
    $versions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
    $versions = json_decode($versions, true);
    $latest = $versions['0'];
    $jsonSpellSummoner = file_get_contents('https://ddragon.leagueoflegends.com/cdn/' . $latest . '/data/fr_FR/summoner.json');
    $jsonSpellSummoner = json_decode($jsonSpellSummoner, true);
    $listSpellSummoner = $jsonSpellSummoner['data'];
    foreach ($listSpellSummoner as $key => $value) {
        if ($listSpellSummoner[$key]['key'] == $id) {
            return $listSpellSummoner[$key];
        }
    }
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style_historique.css">
    <title>Historique</title>
</head>
<body>
    
    <section class="historique">
        <div class="mainframe">
        <div class="all_ban">
            <div class="ban_red">
                <div class="win">
                    <?php if($matchLolByGames['info']['teams'][0]['win'] == true) {
                        ?> <span class="green">Victoire</span> <?php
                    }else
                    {
                        ?> <span class="red">Defaite</span> <?php
                    }
                    ?>

                </div>
                <div class="kda_team"> <?= $killRed ?>/<?= $deathRed ?>/<?= $assistRed ?> </div>
                <div class="gold_team"> <?= $goldRed ?>  <img  class="img_gold"src="/img/goldM.png" alt=""></div>
            </div>
            <div class="ban_blue">
                <div class="gold_team"> <img  class="img_gold"src="/img/goldM.png" alt=""><?= $goldBlue ?> </div>
                <div class="kda_team"> <?= $killBlue ?>/<?= $deathBlue ?>/<?= $assistBlue ?> </div>
                <div class="win"> <?php if($matchLolByGames['info']['teams'][1]['win'] == true) {
                        ?> <span class="green"> Victoire </span> <?php
                    }else
                    {
                        ?> <span class="red">Defaite </span><?php
                    }
                    ?></div>
            </div>
        </div>
        <div class="all_ban">
            <div class="banned_red">
                <div> BAN&nbsp;:&nbsp;&nbsp;</div>
                <?php foreach ($matchLolByGames['info']['teams'][0]['bans'] as $arrBanRed){
                    $nomChampionPartieBan = getChampionInfo($arrBanRed['championId']);
                    if ($nomChampionPartieBan['id'] == NULl) {
                    $iconSummonerGameBan = '/img/empty_items.png';
                     } else {
                    $iconSummonerGameBan = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $nomChampionPartieBan['id'] . '.png';
                    } ?>
                <img class="banned" src="<?= $iconSummonerGameBan?>" alt="" title="<?= $nomChampionPartieBan['id'] ?>">
                <?php }?>
            </div>
          <div class="banned_blue">
            <div> BAN&nbsp;:&nbsp;&nbsp;</div>
              <?php foreach ($matchLolByGames['info']['teams'][1]['bans'] as $arrBanBlue){
                  $nomChampionPartieBanBlue = getChampionInfo($arrBanBlue['championId']);
                  if ($nomChampionPartieBanBlue['id'] == NULl) {
                      $iconSummonerGameBanBlue = '/img/empty_items.png';
                  } else {
                      $iconSummonerGameBanBlue = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $nomChampionPartieBanBlue['id'] . '.png';
                  } ?>
                  <img class="banned" src="<?= $iconSummonerGameBanBlue?>" alt="" title="<?= $nomChampionPartieBanBlue['id'] ?>">
              <?php }?>
          </div>
        </div>
            <div class="game_historic">
            <div class="left_side">
                <?php for($i=0; $i < 5 ; $i++){
                    $iconChampRed = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $matchLolByGames['info']['participants'][$i]['championName'] . '.png';
                    ?>
                <div class="row_histo">
                    <div class="name">
                        <div class="champion_selected">
                            <img class="champ_icon_champ"src="<?= $iconChampRed ?>" alt="" title="<?= $matchLolByGames['info']['participants'][$i]['championName'] ?>">
                        </div>
                        <div class="name_summoner">
                            <div><?= $matchLolByGames['info']['participants'][$i]['summonerName']?></div>
                            <div>Rank</div>
                            <div>Lvl:&nbsp;<?= $matchLolByGames['info']['participants'][$i]['champLevel']?></div>
                        </div>
                        <div class="champion_level"> 
                            <div><?= $matchLolByGames['info']['participants'][$i]['kills']?>/<?= $matchLolByGames['info']['participants'][$i]['deaths']?>/<?= $matchLolByGames['info']['participants'][$i]['assists']?></div>
                            <div class="kda"><?= $matchLolByGames['info']['participants'][$i]['goldEarned']?><img class="kda_special" src="/img/goldM.png" ></div>
                            <div class="kda"><?= $matchLolByGames['info']['participants'][$i]['totalMinionsKilled'] +  $matchLolByGames['info']['participants'][$i]['neutralMinionsKilled'] ?> <img class="kda_special"src="/img/sbire.PNG" ></div>
                        </div>
                        <div class="icons">
                            <div class="mini_ico">
                                <?php
                                $spell1 = getSummonerSpellInfo($matchLolByGames['info']['participants'][$i]['summoner1Id']);
                                $spell2 = getSummonerSpellInfo($matchLolByGames['info']['participants'][$i]['summoner2Id']);

                                ?>
                                <img class="champ_icon_mini"src="http://ddragon.leagueoflegends.com/cdn/<?= $latest ?>/img/spell/<?= $spell1['id'] ?>.png" alt="" title="<?= $spell1['name'] ?>">
                                <img class="champ_icon_mini"src="http://ddragon.leagueoflegends.com/cdn/<?= $latest ?>/img/spell/<?= $spell2['id'] ?>.png" alt="" title="<?= $spell2['name'] ?>">
                            </div>
                            <?php $runePrincipal = getRunesInfo($matchLolByGames['info']['participants'][$i]['perks']['styles'][0]['style'] , $matchLolByGames['info']['participants'][$i]['perks']['styles'][0]['selections'][0]['perk']);
                            ?>
                            <img class="champ_icon"src="https://ddragon.canisback.com/img/<?= $runePrincipal['icon']?>" alt="" title="<?= $runePrincipal['name']?>">
                        </div>
                        <div class="items">
                            <?php if ($matchLolByGames['info']['participants'][$i]['item0'] != 0) {
                                $iconItem0 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item0'] . '.png';
                                ?> <img class="items_icon" src="<?php echo $iconItem0 ?>"><?php
                            }
                            else{
                                ?> <img class="items_icon" src="/img/empty_items.png"><?php
                            }
                            if ($matchLolByGames['info']['participants'][$i]['item1'] != 0) {
                                $iconItem1 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item1'] . '.png';
                                ?> <img class="items_icon" src="<?php echo $iconItem1 ?>"><?php
                            }
                            else{
                                ?> <img class="items_icon" src="/img/empty_items.png"><?php
                            }
                            if ($matchLolByGames['info']['participants'][$i]['item2'] != 0) {
                                $iconItem2 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item2'] . '.png';
                                ?> <img class="items_icon" src="<?php echo $iconItem2 ?>"><?php
                            }
                            else{
                                ?> <img class="items_icon" src="/img/empty_items.png"><?php
                            }
                            if ($matchLolByGames['info']['participants'][$i]['item6'] != 0) {
                                $iconItem3 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item6'] . '.png';
                                ?> <img class="items_icon" src="<?php echo $iconItem3 ?>"><?php
                            }
                            else{
                                ?> <img class="items_icon" src="/img/empty_items.png"><?php
                            }
                            if ($matchLolByGames['info']['participants'][$i]['item4'] != 0) {
                                $iconItem4 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item4'] . '.png';
                                ?> <img class="items_icon" src="<?php echo $iconItem4 ?>"><?php
                            }
                            else{
                                ?> <img class="items_icon" src="/img/empty_items.png"><?php
                            }
                            if ($matchLolByGames['info']['participants'][$i]['item5'] != 0) {
                                $iconItem5 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item5'] . '.png';
                                ?> <img class="items_icon" src="<?php echo $iconItem5 ?>"><?php
                            }
                            else{
                                ?> <img class="items_icon" src="/img/empty_items.png"><?php
                            }
                            if ($matchLolByGames['info']['participants'][$i]['item3'] != 0) {
                                $iconItem6 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item3'] . '.png';
                                ?> <img class="items_icon" src="<?php echo $iconItem6 ?>"><?php
                            }
                            else{
                                ?> <img class="items_icon" src="/img/empty_items.png"><?php
                            }
                                ?>
                        </div>
                    </div>
                </div>
                    <div class="barre"></div>
                <?php }?>


            </div>

            <div class="right_side">
                    <?php for($i=5; $i < 10 ; $i++){
                        $iconChampRed = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $matchLolByGames['info']['participants'][$i]['championName'] . '.png';
                        ?>
                        <div class="row_histo">
                            <div class="name">
                                <div class="champion_selected">
                                    <img class="champ_icon_champ"src="<?= $iconChampRed ?>" alt="" title="<?= $matchLolByGames['info']['participants'][$i]['championName'] ?>">
                                </div>
                                <div class="name_summoner">
                                    <div><?= $matchLolByGames['info']['participants'][$i]['summonerName']?></div>
                                    <div>Rank</div>
                                    <div>Lvl:&nbsp;<?= $matchLolByGames['info']['participants'][$i]['champLevel']?></div>
                                </div>
                                <div class="champion_level">
                                    <div><?= $matchLolByGames['info']['participants'][$i]['kills']?>/<?= $matchLolByGames['info']['participants'][$i]['deaths']?>/<?= $matchLolByGames['info']['participants'][$i]['assists']?></div>
                                    <div class="kda"><?= $matchLolByGames['info']['participants'][$i]['goldEarned']?><img class="kda_special" src="/img/goldM.png" ></div>
                                    <div class="kda"><?= $matchLolByGames['info']['participants'][$i]['totalMinionsKilled'] +  $matchLolByGames['info']['participants'][$i]['neutralMinionsKilled'] ?> <img class="kda_special"src="/img/sbire.PNG" ></div>
                                </div>
                                <div class="icons">
                                    <div class="mini_ico">
                                        <?php
                                        $spell1 = getSummonerSpellInfo($matchLolByGames['info']['participants'][$i]['summoner1Id']);
                                        $spell2 = getSummonerSpellInfo($matchLolByGames['info']['participants'][$i]['summoner2Id']);
                                        ?>
                                        <img class="champ_icon_mini"src="http://ddragon.leagueoflegends.com/cdn/<?= $latest ?>/img/spell/<?= $spell1['id'] ?>.png" alt="" title="<?= $spell1['name'] ?>">
                                        <img class="champ_icon_mini"src="http://ddragon.leagueoflegends.com/cdn/<?= $latest ?>/img/spell/<?= $spell2['id'] ?>.png" alt="" title="<?= $spell2['name'] ?>">
                                    </div>
                                     <?php $runePrincipal = getRunesInfo($matchLolByGames['info']['participants'][$i]['perks']['styles'][0]['style'] , $matchLolByGames['info']['participants'][$i]['perks']['styles'][0]['selections'][0]['perk']); ?>
                                    <img class="champ_icon"src="https://ddragon.canisback.com/img/<?= $runePrincipal['icon']?>" alt="" title="<?= $runePrincipal['name']?>">
                                </div>
                                <div class="items">

                                    <?php if ($matchLolByGames['info']['participants'][$i]['item0'] != 0) {
                                    $iconItem0 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item0'] . '.png';
                                    ?> <img class="items_icon" src="<?php echo $iconItem0 ?>"><?php
                                    }
                                    else{
                                        ?> <img class="items_icon" src="/img/empty_items.png"><?php
                                    }
                                    if ($matchLolByGames['info']['participants'][$i]['item1'] != 0) {
                                    $iconItem1 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item1'] . '.png';
                                    ?> <img class="items_icon" src="<?php echo $iconItem1 ?>"><?php
                                    }
                                    else{
                                        ?> <img class="items_icon" src="/img/empty_items.png"><?php
                                    }
                                    if ($matchLolByGames['info']['participants'][$i]['item2'] != 0) {
                                    $iconItem2 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item2'] . '.png';
                                    ?> <img class="items_icon" src="<?php echo $iconItem2 ?>"><?php
                                    }
                                    else{
                                        ?> <img class="items_icon" src="/img/empty_items.png"><?php
                                    }
                                    if ($matchLolByGames['info']['participants'][$i]['item6'] != 0) {
                                    $iconItem3 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item6'] . '.png';
                                    ?> <img class="items_icon" src="<?php echo $iconItem3 ?>"><?php
                                    }
                                    else{
                                        ?> <img class="items_icon" src="/img/empty_items.png"><?php
                                    }
                                    if ($matchLolByGames['info']['participants'][$i]['item4'] != 0) {
                                    $iconItem4 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item4'] . '.png';
                                    ?> <img class="items_icon" src="<?php echo $iconItem4 ?>"><?php
                                    }
                                    else{
                                        ?> <img class="items_icon" src="/img/empty_items.png"><?php
                                    }
                                    if ($matchLolByGames['info']['participants'][$i]['item5'] != 0) {
                                    $iconItem5 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item5'] . '.png';
                                    ?> <img class="items_icon" src="<?php echo $iconItem5 ?>"><?php
                                    }
                                    else{
                                        ?> <img class="items_icon" src="/img/empty_items.png"><?php
                                    }
                                    if ($matchLolByGames['info']['participants'][$i]['item3'] != 0) {
                                    $iconItem6 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $matchLolByGames['info']['participants'][$i]['item3'] . '.png';
                                    ?> <img class="items_icon" src="<?php echo $iconItem6 ?>"><?php
                                                }
                                    else{
                                        ?> <img class="items_icon" src="/img/empty_items.png"><?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="barre"></div>
                    <?php }?>
            </div>
        </div>
        </div>
    </section>
</body>
</html>