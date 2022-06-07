<link rel="stylesheet" href="../css/style_champ.css">
<?php
include_once('../Api.php');
include_once('../top.php');
$operation = $_GET['operation'] ?? '';
$nomChamp = $_GET['nomChamp'] ?? '';
$Api = new Api();
$url = 'https://euw1.api.riotgames.com';
$versions = file_get_contents('https://ddragon.leagueoflegends.com/api/versions.json');
$versions = json_decode($versions, true);
$latest = $versions['0'];
$jsonChamp = file_get_contents('http://ddragon.leagueoflegends.com/cdn/' . $latest . '/data/fr_FR/champion.json');

$jsonChamp = json_decode($jsonChamp, true);
$list = $jsonChamp['data'];


if ($operation == ""){
?>

<main>
    <section class="all_champs">
        <?php foreach ($list as $key => $value) {
            $splashArt = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/' . $list[$key]['id'] . '_0.jpg';
            ?>
            <a href="champion_page.php?operation=search&nomChamp=<?php echo $list[$key]['id'] ?>" class="champ_card"
               style="background-image:url('<?php echo $splashArt ?>')">
                <div class="champ_name"> <?php echo $list[$key]['id'] ?></div>
            </a>
        <?php } ?>
    </section>

    <?php }
    if ($operation == 'search') { ?>
        <section class="champ_info">
            <div class="champ_header">
                <?php $splashArt = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/' . $nomChamp . '_0.jpg';
                $jsonChamp = file_get_contents('http://ddragon.leagueoflegends.com/cdn/' . $latest . '/data/fr_FR/champion/' . $nomChamp . '.json');

                $jsonChamp = json_decode($jsonChamp, true);
                $list = $jsonChamp['data'];

                ?>
                <img class="img_champ" src="<?php echo $splashArt ?>" alt="">
                <div class="title_champ">
                    <h4><?php echo $nomChamp ?></h4>
                    <h3><?php echo $list[$nomChamp]['title'] ?></h3>
                </div>
            </div>
        </section>
        <section class="champ_all_ability">
            <div class="bloc_cap"">
                <div class="champs_ability">
                <h5>Passif</h5>
                    <div>
                        <div class="cap_passive">
                            <?php $imgPassive = 'https://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/passive/' . $list[$nomChamp]['passive']['image']['full']; ?>
                            <img class="cap_img" src="<?php echo $imgPassive ?>" alt="">
                            <div class="cap_name"><?php echo $list[$nomChamp]['passive']['name'] ?></div>
                        </div>
                        <p><?php echo $list[$nomChamp]['passive']['description'] ?></p>
                    </div>
                </div>
                <div class="champs_ability">
                <h5>Capacité</h5>

                    <?php foreach ($list[$nomChamp]['spells'] as $spell) {
                        $imgSpell = 'http://ddragon.leagueoflegends.com/cdn/' . $latest . '/img/spell/' . $spell['image']['full'];

                        ?>
                        <div>
                            <div class="cap">
                                <img class="cap_img" src="<?php echo $imgSpell ?>" alt="">
                                <div class="cap_name"><?php echo $spell['name'] ?></div>
                            </div>

                            <?php
                            
//                            $spell['tooltip'] = str_replace('{{ e6 }}',$spell['effectBurn'][6],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e5 }}',$spell['effectBurn'][5],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e4 }}',$spell['effectBurn'][4],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e3 }}',$spell['effectBurn'][3],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e2 }}',$spell['effectBurn'][2],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e1 }}',$spell['effectBurn'][1],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e6damage }}',$spell['effectBurn'][6],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e5damage }}',$spell['effectBurn'][5],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e4damage }}',$spell['effectBurn'][4],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e3damage }}',$spell['effectBurn'][3],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e2damage }}',$spell['effectBurn'][2],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e1damage }}',$spell['effectBurn'][1],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e4 }}',$spell['effectBurn'][4],$spell['tooltip']);
//                            $spell['tooltip'] = str_replace('{{ e4 }}',$spell['effectBurn'][4],$spell['tooltip']);
//                            var_dump($spell['effectBurn']);?>
                            <p><?php echo $spell['description'] ?></p>
                        </div>

                    <?php } ?>
                </div>
            </div>
    <div class="all_stats">
        <div class="stats_screen">
            <div class="stats_row">
                <div class="status_all">
                    <div class="status">
                        <div class="base_stat pv">Base PV</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['hp']?></div>
                    </div>
                    <div class="status">
                        <div class="base_stat pv">PV par Level</div>
                        <div class="stat">+ <?php echo $list[$nomChamp]['stats']['hpperlevel']?></div>
                    </div>
                </div>
            <div class="combined_stat">
                <div class="base_stat pv">Pv level 18</div>
                <div class="stat"><?php echo $list[$nomChamp]['stats']['hp'] + ($list[$nomChamp]['stats']['hpperlevel'] * 17)?></div>
            </div>
            </div>

             <div class="stats_row">
                <div class="status_all">
                    <div class="status">
                        <div class="base_stat armor">Base Armure</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['armor']?></div>
                    </div>
                    <div class="status">
                        <div class="base_stat armor">Armure par Level</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['armorperlevel']?></div>
                    </div>
                </div>
            <div class="combined_stat">
                <div class="base_stat armor">Armure level 18</div>
                <div class="stat"><?php echo $list[$nomChamp]['stats']['armor'] + ($list[$nomChamp]['stats']['armorperlevel'] * 17)?></div>
            </div>
            </div>

            <div class="stats_row">
                <div class="status_all">
                    <div class="status">
                        <div class="base_stat anti_magic">Base Anti-Magique</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['spellblock']?></div>
                    </div>
                    <div class="status">
                        <div class="base_stat anti_magic">Anti-Magique par Level</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['spellblockperlevel']?></div>
                    </div>
                </div>
                <div class="combined_stat">
                    <div class="base_stat anti_magic">Anti-Magique level 18</div>
                    <div class="stat"><?php echo $list[$nomChamp]['stats']['spellblock'] + ($list[$nomChamp]['stats']['spellblockperlevel'] * 17)?></div>
                </div>
            </div>

            <div class="stats_row">
                <div class="status_all">
                    <div class="status">
                        <div class="base_stat attack">Base dégâts d'attaque</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['attackdamage']?></div>
                    </div>
                    <div class="status">
                        <div class="base_stat attack">Dégâts d'attaque par Level</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['attackdamageperlevel']?></div>
                    </div>
                </div>
                <div class="combined_stat">
                    <div class="base_stat attack">Dégâts d'attaque level 18</div>
                    <div class="stat"><?php echo $list[$nomChamp]['stats']['attackdamage'] + ($list[$nomChamp]['stats']['attackdamageperlevel'] * 17)?></div>
                </div>
            </div>

            <div class="stats_row">
                <div class="status_all">
                    <div class="status">
                        <div class="base_stat attack_speed">Base vitesse d'attaque</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['attackspeed']?></div>
                    </div>
                    <div class="status">
                        <div class="base_stat attack_speed">Vitesse d'attaque par Level</div>
                        <div class="stat"><?php echo $list[$nomChamp]['stats']['attackspeedperlevel']?></div>
                    </div>
                </div>
                <div class="combined_stat">
                    <div class="base_stat attack_speed">Vitesse d'attaque level 18</div>
                    <?php
                    $calculAttackSpeed = $list[$nomChamp]['stats']['attackspeed'] * (1 + $list[$nomChamp]['stats']['attackspeedperlevel'] * 18 / 100);
                    $AttackSpeed = number_format($calculAttackSpeed, 3, ',', ' '); ?>
                    <div class="stat"><?= $AttackSpeed ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
    <?php } ?>
</main>
<?php include_once('../footer.php'); ?>
</body>
</html>