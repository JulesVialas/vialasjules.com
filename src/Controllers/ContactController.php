<?php

namespace App\Controllers;

/**
 * Contrôleur pour la page "Projets".
 *
 * Gère l'affichage de la page "Projets" du site web.
 *
 * @package App\Controllers
 * @author Jules Vialas
 * @version 1.0.0
 */
class ContactController {

    /**
     * Affiche la page "Contact".
     *
     * Inclut le template de la page "Contact" depuis les vues.
     *
     * @return void
     */
    public function get(): void {
        include __DIR__ . '/../Views/layouts/contact.php';
    }
}
