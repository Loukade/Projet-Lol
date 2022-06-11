<?php
session_start();

require_once 'configs/chemins.class.php';


require_once chemins::CONFIGS."Api.php"; // chemins vers mysql_config.class.php

//Rmq : si les modèles étaient "découpés", ils seraient inclus dans chaque controleur associé et non dans le controleur principal


// Affichage de l'entête de la page 

require_once chemins::VUES_PERMANENTES."top.php";


ob_start();
if (!isset($_REQUEST['Controleur']))
{
   require_once(Chemins::VUES_SUMMONER . "summonerPage.php");
}    
else {

    $classeControleur = 'Controleur' . $_REQUEST['Controleur']; //ex : ControleurProduits
    $fichierControleur = $classeControleur . ".class.php"; //ex : ControleurProduits.class.php
    require_once(Chemins::CONTROLEURS . $fichierControleur);

    $objetControleur = new $classeControleur(); //ex : $objetControleur = new ControleurProduits();
    if(isset($_REQUEST['action'])){
        $action = $_REQUEST['action'];
        $objetControleur->$action();
    }
}
$content = ob_get_clean();
echo $content;


//Affichage du pied de page 

require_once(Chemins::VUES_PERMANENTES . "footer.php");

