<?php
include('summonerPage.php');

if(isset($_REQUEST['Pseudo']))
    $searchSummoners = $_REQUEST['Pseudo'];


$rep = 'good';
$partieTrouve = '';
$messagePseudoInconnu = '';
$Api = new Api();
$url = 'https://euw1.api.riotgames.com';
$searchSummoners = str_replace(" ", '%20', $searchSummoners);
$summoners = $url . '/lol/summoner/v4/summoners/by-name/' . $searchSummoners;
$datasSummoners = $Api->requestApi($summoners, 'GET', '', '');
if (isset($datasSummoners['status']['status_code']) != 404 || $datasSummoners == NULL) {
    $idSummoner = $datasSummoners['id'];
    $idAccount = $datasSummoners['accountId'];
    $puuid = $datasSummoners['puuid'];


    $europeApi = 'https://europe.api.riotgames.com';
    $ChampMasteriesSummoner = $url . '/lol/champion-mastery/v4/champion-masteries/by-summoner/' . $idSummoner;
    $datasChampMasteriesSummoner = $Api->requestApi($ChampMasteriesSummoner, 'GET', '', '');
    $idChamp = $datasChampMasteriesSummoner['0']['championId'];
    $versions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
    $versions = json_decode($versions, true);
    $latest = $versions['0'];

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

    function getPositionChamp($idChamp)
    {
        $Api = new Api();
        $summoners = 'http://cdn.merakianalytics.com/riot/lol/resources/latest/en-US/championrates.json';
        $championRatePosition = $Api->requestApi($summoners, 'GET', '', '');

        for($i = 1; $i < count($championRatePosition['data']); $i++){
            if($i = $idChamp){
                if($idChamp == 200){
                    return 'JUNGLE';
                }

                if($championRatePosition['data'][$i]['TOP']['playRate'] > 0 && $championRatePosition['data'][$i]['MIDDLE']['playRate'] == 0 && $championRatePosition['data'][$i]['JUNGLE']['playRate'] == 0 && $championRatePosition['data'][$i]['BOTTOM']['playRate'] == 0 && $championRatePosition['data'][$i]['UTILITY']['playRate'] == 0)
                    return 'TOP';
                elseif($championRatePosition['data'][$i]['MIDDLE']['playRate'] > 0 && $championRatePosition['data'][$i]['TOP']['playRate'] == 0 && $championRatePosition['data'][$i]['JUNGLE']['playRate'] == 0 && $championRatePosition['data'][$i]['BOTTOM']['playRate'] == 0 && $championRatePosition['data'][$i]['UTILITY']['playRate'] == 0)
                    return 'MIDDLE';
                elseif($championRatePosition['data'][$i]['JUNGLE']['playRate'] > 0 && $championRatePosition['data'][$i]['TOP']['playRate'] == 0 && $championRatePosition['data'][$i]['MIDDLE']['playRate'] == 0 && $championRatePosition['data'][$i]['BOTTOM']['playRate'] == 0 && $championRatePosition['data'][$i]['UTILITY']['playRate'] == 0)
                    return 'JUNGLE';
                elseif($championRatePosition['data'][$i]['BOTTOM']['playRate'] > 0 && $championRatePosition['data'][$i]['TOP']['playRate'] == 0 && $championRatePosition['data'][$i]['MIDDLE']['playRate'] == 0 && $championRatePosition['data'][$i]['JUNGLE']['playRate'] == 0 && $championRatePosition['data'][$i]['UTILITY']['playRate'] == 0)
                    return 'BOTTOM';
                elseif ($championRatePosition['data'][$i]['UTILITY']['playRate'] > 0 && $championRatePosition['data'][$i]['TOP']['playRate'] == 0 && $championRatePosition['data'][$i]['MIDDLE']['playRate'] == 0 && $championRatePosition['data'][$i]['JUNGLE']['playRate'] == 0 && $championRatePosition['data'][$i]['BOTTOM']['playRate'] == 0)
                    return 'SUPPORT';

            }
        }
    }


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

    $nomChampion = getChampionInfo($idChamp);

    $splashArt = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/' . $nomChampion['id'] . '_0.jpg';

    $iconSummoner = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/profileicon/' . $datasSummoners['profileIconId'] . '.png';

    $detailSummoner = $url . '/lol/league/v4/entries/by-summoner/' . $idSummoner;
    $datasDetailsSummoners = $Api->requestApi($detailSummoner, 'GET', '', '');

    $recherchePartie = $url . '/lol/spectator/v4/active-games/by-summoner/' . $idSummoner;
    $datasRecherchePartie = $Api->requestApi($recherchePartie, 'GET', '', '');
    if (isset($datasRecherchePartie['status']['status_code']) != 404) {
        $partieTrouve = 'trouve';

    }


} else
    $rep = 'Erreur';

 if ($rep == "good") {
     ?>
        <section class="container_2">
            <main class="left_side ">
                <div class="profil">
                    <div class="profil_header" style="background-image: url('<?php echo $splashArt ?>')">
                        <img class="icone_summoner" src="<?php echo $iconSummoner ?>" alt="profil_picture">

                        <div class="profil_info">
                            <h3><?php echo $datasSummoners['name'] ?></h3>
                            <div> Level <?php echo $datasSummoners['summonerLevel'] ?></div>
                        </div>
                    </div>
                    <div class="all_ranked_type">
                        <?php


                        // il est en game de placement alors// {
                        // "miniSeries": {
                        //  "target": 3,
                        //	"wins": 2,
                        //	"losses": 2,
                        //	"progress": "LWLWN"
                        //	}
                        //}
                        foreach ($datasDetailsSummoners as $arrDetailsSummoners) {

                            if (!empty($arrDetailsSummoners['queueType'])) {
                                $arrDetailsSummoners['queueType'] = str_replace("_", " ", $arrDetailsSummoners['queueType']);
                                ?>
                                <div class="game_type_info">
                                    <h3><?php echo $arrDetailsSummoners['queueType'] ?></h3>
                                    <div class="profil_rank">
                                        <img class="img_rank"
                                             src="/img/<?php echo $arrDetailsSummoners['tier'] ?>.png"
                                             alt="">
                                        <div>
                                            <h2><?php echo $arrDetailsSummoners['tier'] . ' ' . $arrDetailsSummoners['rank'] ?></h2>
                                            <span><?php echo $arrDetailsSummoners['leaguePoints'] ?> LP</span>
                                            <span><?php if(isset($arrDetailsSummoners['miniSeries'])){

                                                    $arrDetailsSummoners['miniSeries']['progress'] = str_replace('L', '❌', $arrDetailsSummoners['miniSeries']['progress']);
                                                    $arrDetailsSummoners['miniSeries']['progress'] = str_replace('W', '✔️', $arrDetailsSummoners['miniSeries']['progress']);
                                                    $arrDetailsSummoners['miniSeries']['progress'] = str_replace('N', '-', $arrDetailsSummoners['miniSeries']['progress']);
                                                    echo $arrDetailsSummoners['miniSeries']['progress'];

                                                }?> </span>
                                        </div>
                                    </div>
                                    <div class="stat_win">
                                        <div class="winrate">
                                            <div>Victoire : <?php echo $arrDetailsSummoners['wins'] ?></div>
                                        </div>
                                        <div class="loserate">
                                            <div>Défaite : <?php echo $arrDetailsSummoners['losses'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else {
                                ?>
                                <div class="game_type_info">
                                    <h3>Unranked</h3>
                                    <div class="profil_rank">
                                        <img class="img_rank" src="/img/unranked.png" alt="">
                                    </div>
                                </div>
                                <?php
                            }
                        }

                        ?>
                    </div>
                    <div class="all_mastery">
                        <?php
                        $ChampMasteriesSummoner = $url . '/lol/champion-mastery/v4/champion-masteries/by-summoner/' . $idSummoner;
                        $datasChampMasteriesSummoner = $Api->requestApi($ChampMasteriesSummoner, 'GET', '', '');

                        for ($i = 0; $i < 3; $i++) {
                            $champInfo = getChampionInfo($datasChampMasteriesSummoner[$i]['championId']);
                            $masteries = $datasChampMasteriesSummoner[$i]['championLevel'];
                            $pointMasteries = $datasChampMasteriesSummoner[$i]['championPoints'];
                            $imageChamp = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $champInfo['id'] . '.png';
                            ?>

                            <div class="mastery">
                                <a href="/Champion/<?php echo $champInfo['name'] ?>"><img class="img_mastery_1" src="<?php echo $imageChamp ?>" alt="" title="<?php echo $champInfo['name'] ?>"></a>
                                <img class="img_mastery_1" src="/img/masteries/<?php echo $masteries ?>.jpg" alt="">
                                <div><?php echo $champInfo['name'] ?></div>
                                <?php $pointMasteries = number_format($pointMasteries, 0);
                                $pointMasteries = str_replace(",", " ", $pointMasteries); ?>
                                <div><?php echo $pointMasteries . " " ?> Points</div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </main>
            <?php
            if ($partieTrouve != '') {

            ?>
            <main class="right_side">
                <div class="game_screen">


                        <h3 class="game_type"><?php if ($datasRecherchePartie['gameQueueConfigId'] == 420) {
                                ?> Ranked Solo Duo 5V5
                            <?php } else if ($datasRecherchePartie['gameQueueConfigId'] == 400) { ?>
                                5v5 Draft
                            <?php } else if ($datasRecherchePartie['gameQueueConfigId'] == 440) { ?>
                                5v5 Ranked Flex games
                            <?php } else if ($datasRecherchePartie['gameQueueConfigId'] == 450) { ?>
                                5v5 ARAM games
                            <?php } else if ($datasRecherchePartie['gameQueueConfigId'] == 325) { ?>
                                Normal games
                            <?php } else if ($datasRecherchePartie['gameQueueConfigId'] == 430) { ?>
                                5v5 Blind Pick games
                            <?php } else { ?>
                                Mode de jeu temporaire
                            <?php } ?>
                        </h3>

                        <div class="champ_row_bis">
                            <?php

                            if (!empty($datasRecherchePartie['bannedChampions'])) {
                                ?>
                                <div class="ban_blue"> Ban:<?php
                                    for ($i = 0; $i < 5; $i++) {
                                        $nomChampionPartieBan = getChampionInfo($datasRecherchePartie['bannedChampions'][$i]['championId']);
                                        if ($nomChampionPartieBan['id'] == NULl) {
                                            $iconSummonerGameBan = '';
                                        } else {
                                            $iconSummonerGameBan = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $nomChampionPartieBan['id'] . '.png'; ?>
                                            <img src="<?php echo $iconSummonerGameBan ?>"
                                                 alt="<?php echo $nomChampionPartieBan['id'] ?>"
                                                 title="<?php echo $nomChampionPartieBan['id'] ?>" class="banned_champ">

                                        <?php }
                                    }
                                    ?></div>
                                <div class="ban_red"> Ban: <?php
                                    for ($i = 5; $i < 10; $i++) {
                                        $nomChampionPartieBan = getChampionInfo($datasRecherchePartie['bannedChampions'][$i]['championId']);
                                        if ($nomChampionPartieBan['id'] == NULl) {
                                            $iconSummonerGameBan = '';
                                        } else {
                                            $iconSummonerGameBan = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $nomChampionPartieBan['id'] . '.png'; ?>
                                            <img src="<?php echo $iconSummonerGameBan ?>"
                                                 alt="<?php echo $nomChampionPartieBan['id'] ?>"
                                                 title="<?php echo $nomChampionPartieBan['id'] ?>" class="banned_champ">

                                        <?php }
                                    }
                                    ?></div>
                            <?php } ?>
                        </div>

                        <div class="game_overall">
                            <div class="collum_blue">

                                <?php for ($i = 0; $i < 5; $i++) {
                                    $detailSummonerGameBlue = $url . '/lol/league/v4/entries/by-summoner/' . $datasRecherchePartie['participants'][$i]['summonerId'];
                                    $datasDetailsSummonersGameBlue = $Api->requestApi($detailSummonerGameBlue, 'GET', '', '');
                                    $rankSummonnerBlue = 'unranked';
                                    foreach ($datasDetailsSummonersGameBlue as $arrDetailsSummonersGameBlue) {
                                        if ($arrDetailsSummonersGameBlue['queueType'] == 'RANKED_FLEX_SR' && $datasRecherchePartie['gameQueueConfigId'] == 440) {
                                            $rankSummonnerBlue = $arrDetailsSummonersGameBlue['tier'] . " " . $arrDetailsSummonersGameBlue['rank'];
                                        } elseif ($arrDetailsSummonersGameBlue['queueType'] == 'RANKED_SOLO_5x5') {
                                            $rankSummonnerBlue = $arrDetailsSummonersGameBlue['tier'] . " " . $arrDetailsSummonersGameBlue['rank'];
                                        }
                                    }
                                    ?>
                                    <div class="champ_row">
                                        <div class="summ_name">


                                            <?php $SummonerName = $datasRecherchePartie['participants'][$i]['summonerName'] ;
                                            $nomChampionPartie = getChampionInfo($datasRecherchePartie['participants'][$i]['championId']);
                                            $positionChampBlue = getPositionChamp($datasRecherchePartie['participants'][$i]['championId']);
                                            ?>
                                            <div><a style="color: black;"
                                                    href="/Summoner/<?php echo $SummonerName ?>"><?php echo $SummonerName ?></a>
                                            </div>
                                            <div class="rank"><?php echo $rankSummonnerBlue ?> </div>
                                            <div class="rank"><?php echo $positionChampBlue ?> </div>
                                        </div>

                                        <?php

                                        $iconSummonerGame = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $nomChampionPartie['id'] . '.png'; ?>
                                        <a href="/Champion/<?php echo $nomChampionPartie['id'] ?>"><img class="champ_selected" src="<?php echo $iconSummonerGame ?>"
                                             alt="<?php echo $nomChampionPartie['id'] ?>"
                                             title="<?php echo $nomChampionPartie['id'] ?>"></a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="collum_red">

                                <?php for ($i = 5; $i < 10; $i++) {
                                    $detailSummonerGameRed = $url . '/lol/league/v4/entries/by-summoner/' . $datasRecherchePartie['participants'][$i]['summonerId'];
                                    $datasDetailsSummonersGameRed = $Api->requestApi($detailSummonerGameRed, 'GET', '', '');
                                    $rankSummonnerRed = 'unranked';
                                    foreach ($datasDetailsSummonersGameRed as $arrDetailsSummonersGameRed) {
                                        if ($arrDetailsSummonersGameRed['queueType'] == 'RANKED_FLEX_SR' && $datasRecherchePartie['gameQueueConfigId'] == 440) {
                                            $rankSummonnerRed = $arrDetailsSummonersGameRed['tier'] . " " . $arrDetailsSummonersGameRed['rank'];
                                        } elseif ($arrDetailsSummonersGameRed['queueType'] == 'RANKED_SOLO_5x5') {
                                            $rankSummonnerRed = $arrDetailsSummonersGameRed['tier'] . " " . $arrDetailsSummonersGameRed['rank'];
                                        }
                                    }
                                    ?>
                                    <div class="champ_row">
                                        <?php
                                        $nomChampionPartie = getChampionInfo($datasRecherchePartie['participants'][$i]['championId']);
                                        $positionChampRed = getPositionChamp($datasRecherchePartie['participants'][$i]['championId']);
                                        $iconSummonerGame = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $nomChampionPartie['id'] . '.png'; ?>
                                        <img class="champ_selected"  src="<?php echo $iconSummonerGame ?>"
                                             alt="<?php echo $nomChampionPartie['id'] ?>"
                                             title="<?php echo $nomChampionPartie['id'] ?>">
                                        <div class="summ_name">
                                            <div><a style="color: black;"
                                                    href=""><?php echo $datasRecherchePartie['participants'][$i]['summonerName'] ?></a>
                                            </div>
                                            <div class="rank"><?php echo $rankSummonnerRed ?></div>
                                            <div class="rank"><?php echo $positionChampRed ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>

                </div>
            </main>
                <?php ?>
            <?php } elseif ($partieTrouve == '') {
                $message = 'partie non trouvé';
                ?>
                <!--                        <h4>--><?php //echo $message ?><!--</h4>-->
                <?php
            } ?>
        </section>
        <section class="historic">
            <div class="history_screen">
                <?php $matchLol = $europeApi . '/lol/match/v5/matches/by-puuid/' . $puuid . '/ids';
                $idMatchLol = $Api->requestApi($matchLol, 'GET', '', '');
                foreach ($idMatchLol as $arrMatch) { ?>
                    <div class="historic_game">
                        <div class="username_history">
                            <?php
                            $matchLolById = $europeApi . '/lol/match/v5/matches/' . $arrMatch;
                            $matchLolByGames = $Api->requestApi($matchLolById, 'GET', '', '');
                            try {
                                foreach ($matchLolByGames['info']['participants'] as $arrInfoParticipants) {
                                    ?>

                                    <?php
                                    if ($arrInfoParticipants['summonerName'] == $datasSummoners['name']) {
                                        $nomChampionGame = getChampionInfo($arrInfoParticipants['championId']);
                                        $iconSummonerGameBan = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/champion/' . $nomChampionGame['id'] . '.png';
                                        $iconItem = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/0.png'
                                        ?>
                                        <div class=collum_size_champ>
                                            <a href="/Champion/<?= $nomChampionGame['id'] ?>"><img
                                                        class="img_mastery_3" src="<?= $iconSummonerGameBan ?>"
                                                        title="<?= $nomChampionGame['id'] ?>"></a>
                                        </div>
                                        <div class="collum_info">
                                            <p class="win"><?php if ($arrInfoParticipants['win'] == true) { ?> Victoire <?php } else { ?> Défaite <?php } ?> </p>


                                            <p class="text_gametype"><?php
                                                if ($matchLolByGames['info']['queueId'] == 420) {
                                                    ?> Ranked Solo Duo 5V5
                                                <?php } else if ($matchLolByGames['info']['queueId'] == 400) { ?>
                                                    5v5 Draft
                                                <?php } else if ($matchLolByGames['info']['queueId'] == 440) { ?>
                                                    5v5 Ranked Flex games
                                                <?php } else if ($matchLolByGames['info']['queueId'] == 450) { ?>
                                                    5v5 ARAM games
                                                <?php } else if ($matchLolByGames['info']['queueId'] == 325) { ?>
                                                    Normal games
                                                <?php } else if ($matchLolByGames['info']['queueId'] == 430) { ?>
                                                    5v5 Blind Pick games
                                                <?php } else if ($matchLolByGames['info']['queueId'] == 900) { ?>
                                                    URF
                                                <?php } else { ?>
                                                    Mode de jeu temporaire
                                                <?php } ?>
                                            </p>
                                            <div>
                                                <?php $spell1 = getSummonerSpellInfo($arrInfoParticipants['summoner1Id']);
                                                $spell2 = getSummonerSpellInfo($arrInfoParticipants['summoner2Id']); ?>
                                                <img class="summ_skill"
                                                     src="http://ddragon.leagueoflegends.com/cdn/<?= $latest ?>/img/spell/<?= $spell1['id'] ?>.png"
                                                     title="<?= $spell1['name'] ?>">
                                                <img class="summ_skill"
                                                     src="http://ddragon.leagueoflegends.com/cdn/<?= $latest ?>/img/spell/<?= $spell2['id'] ?>.png"
                                                     title="<?= $spell2['name'] ?>">

                                            </div>
                                        </div>
                                        <div class="collum_historic">
                                            <div class="row_historic">
                                                <?php

                                                if ($arrInfoParticipants['item0'] != 0) {
                                                    $iconItem0 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $arrInfoParticipants['item0'] . '.png';
                                                    ?> <img class="items" src="<?php echo $iconItem0 ?>"><?php
                                                }
                                                if ($arrInfoParticipants['item1'] != 0) {
                                                    $iconItem1 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $arrInfoParticipants['item1'] . '.png';
                                                    ?> <img class="items" src="<?php echo $iconItem1 ?>"><?php
                                                }
                                                if ($arrInfoParticipants['item2'] != 0) {
                                                    $iconItem2 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $arrInfoParticipants['item2'] . '.png';
                                                    ?> <img class="items" src="<?php echo $iconItem2 ?>"><?php
                                                }
                                                if ($arrInfoParticipants['item3'] != 0) {
                                                    $iconItem3 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $arrInfoParticipants['item3'] . '.png';
                                                    ?> <img class="items" src="<?php echo $iconItem3 ?>"><?php
                                                }
                                                if ($arrInfoParticipants['item4'] != 0) {
                                                    $iconItem4 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $arrInfoParticipants['item4'] . '.png';
                                                    ?> <img class="items" src="<?php echo $iconItem4 ?>"><?php
                                                }
                                                if ($arrInfoParticipants['item5'] != 0) {
                                                    $iconItem5 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $arrInfoParticipants['item5'] . '.png';
                                                    ?> <img class="items" src="<?php echo $iconItem5 ?>"><?php
                                                }
                                                if ($arrInfoParticipants['item6'] != 0) {
                                                    $iconItem6 = 'https://ddragon.leagueoflegends.com/cdn/12.10.1/img/item/' . $arrInfoParticipants['item6'] . '.png';
                                                    ?> <img class="items" src="<?php echo $iconItem6 ?>"><?php
                                                }
                                                ?>
                                            </div>
                                            <div class="row_historic">
                                                <div class="collum_info_game">
                                                    <p> <?php echo $arrInfoParticipants['kills'] ?>&nbsp;/</p>
                                                    <p> <?php echo $arrInfoParticipants['deaths'] ?>&nbsp;/</p>
                                                    <p> <?php echo $arrInfoParticipants['assists'] ?>&nbsp;</p>
                                                </div>
                                                <div class="collum_info_creep">
                                                    <p>
                                                        <?php echo $arrInfoParticipants['totalMinionsKilled'] + $arrInfoParticipants['neutralMinionsKilled'] ?></p>&nbsp;<img
                                                            class="historic_icon" src="/img/sbire.png" title="Sbire">
                                                </div>
                                                <div class="collum_info_game">
                                                    <p> <?php echo $arrInfoParticipants['goldEarned'] ?></p>&nbsp;<img
                                                            class="historic_icon" src="/img/goldM.png" title="Gold">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="collum_historic">
                                            <div class="row_historic">
                                                <p> Champion level
                                                    : <?php echo $arrInfoParticipants['champLevel'] ?>  </p>
                                            </div>
                                            <div class="row_historic">
                                                <img class="" src="/img/<?= $arrInfoParticipants['teamPosition'] ?>.png"
                                                     alt="" title="<?= $arrInfoParticipants['teamPosition'] ?>">
                                            </div>
                                        </div>

                                        <?php
                                    }

                                }
                            } catch (\Exception $e) {
                                var_dump($e);
                            }

                            ?>

                        </div>
                    </div>
                <?php } ?>
            </div>

        </section>

        <?php
    } else {
        $messagePseudoInconnu = 'Utilisateur non trouvé';
        ?>
        <div class="noneUser">
            <h4><?php echo $messagePseudoInconnu ?> </h4>
        </div>

        <?php
    }
    ?>
    </body>
