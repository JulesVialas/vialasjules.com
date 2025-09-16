<?php

namespace App\Controllers;

/**
 * Contrôleur pour la page d'accueil.
 * 
 * Gère l'affichage de la page principale du site web.
 * 
 * @package App\Controllers
 * @author Jules Vialas
 * @version 1.0.0
 */
class HomeController {
    
    /**
     * Affiche la page d'accueil.
     * 
     * Inclut le template de la page d'accueil depuis les vues.
     * 
     * @return void
     */
    public function get(): void {
        include __DIR__ . '/../Views/layouts/home.php';
    }
}