<!-- ControleurAffichage -->
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControleurAffichage
 *
 * @author lucas.jenvrain
 */
class ControleurAffichage {
    public function afficherSummoner() {
        
        require Chemins::VUES_SUMMONER . 'summonerPage.php'; // affichage de la page des Summoners
    }
    public function afficherDetailSummoner() {

        require Chemins::VUES_SUMMONER . 'summonerDetail.php'; // affichage de la page des Summoners
    }
    public function afficherChampion() {

        require Chemins::VUES_CHAMPION . 'champion_page.php'; // affichage de la page des champions
    }

    public function afficherChampionDetail() {

        require Chemins::VUES_CHAMPION . 'championDetail.php'; // affichage de la page des champions
    }

    public function afficherClassement() {

        require Chemins::VUES_CLASSEMENT . 'classement.php'; // affichage de la page classement
    }

}
