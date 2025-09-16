<?php

namespace App\Controllers;

/**
 * Contrôleur pour la page "À propos".
 *
 * Gère l'affichage de la page "À propos" du site web.
 *
 * @package App\Controllers
 * @author Jules Vialas
 * @version 1.0.0
 */
class AboutController {

    /**
     * Affiche la page "À propos".
     *
     * Inclut le template de la page "À propos" depuis les vues.
     *
     * @return void
     */
    public function get(): void {
        include __DIR__ . '/../Views/layouts/about.php';
    }
}
