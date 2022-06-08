<link rel="stylesheet" href="../../../css/style_champ.css">
<?php
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

?>

<main>
    <section class="all_champs">
        <?php foreach ($list as $key => $value) {
            $splashArt = 'http://ddragon.leagueoflegends.com/cdn/img/champion/splash/' . $list[$key]['id'] . '_0.jpg';
            ?>
            <a href="index.php?Controleur=Affichage&action=afficherChampionDetail&nomChamp=<?php echo $list[$key]['id'] ?>" class="champ_card"
               style="background-image:url('<?php echo $splashArt ?>')">
                <div class="champ_name"> <?php echo $list[$key]['id'] ?></div>
            </a>
        <?php } ?>
    </section>
</main>
</body>
</html>