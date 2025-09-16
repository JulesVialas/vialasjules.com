<?php

namespace App\Services;

/**
 * Service de gestion multilingue pour l'application.
 * 
 * Gère la détection, la persistance et les traductions pour le français et l'anglais.
 * Utilise les sessions, cookies et paramètres URL pour la persistance.
 * 
 * @package App\Services
 * @author Jules Vialas
 * @version 1.0.0
 */
class Language {
    
    /**
     * Code de langue actuellement actif.
     * 
     * @var string
     */
    private static $lang = 'fr';
    
    /**
     * Tableau des traductions pour toutes les langues supportées.
     * 
     * @var array<string, array<string, string>>
     */
    private static $translations = [];
    
    /**
     * Initialise le système de langue.
     * 
     * Détermine la langue à partir de l'URL, session, cookie ou utilise le français par défaut.
     * Sauvegarde la langue dans la session et les cookies pour la persistance.
     * Charge ensuite toutes les traductions.
     * 
     * @return void
     */
    public static function init(): void {
        self::$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? $_COOKIE['site_lang'] ?? 'fr';
        
        if (!in_array(self::$lang, ['fr', 'en'])) {
            self::$lang = 'fr';
        }
        
        $_SESSION['lang'] = self::$lang;
        setcookie('site_lang', self::$lang, time() + (86400 * 30), '/');
        
        self::loadTranslations();
    }
    
    /**
     * Récupère une traduction par sa clé.
     * 
     * Retourne la traduction dans la langue courante ou la clé elle-même
     * si aucune traduction n'est trouvée.
     * 
     * @param string $key Clé de traduction (ex: 'nav.home')
     * @return string Texte traduit ou clé si non trouvée
     */
    public static function get(string $key): string {
        return self::$translations[self::$lang][$key] ?? $key;
    }
    
    /**
     * Récupère le code de la langue actuellement active.
     * 
     * @return string Code de langue ('fr' ou 'en')
     */
    public static function getCurrentLang(): string {
        return self::$lang;
    }
    
    /**
     * Charge toutes les traductions dans le tableau statique.
     * 
     * Définit les traductions pour le français et l'anglais
     * pour la navigation, le footer, les pages et les métadonnées.
     * 
     * @return void
     */
    private static function loadTranslations(): void {
        self::$translations = [
            'fr' => [
                'nav.home' => 'Accueil',
                'nav.about' => 'À Propos',
                'nav.contact' => 'Contact',
                'footer.copyright' => '© 2025 Jules Vialas, tous droits réservés.',
                'home.title' => 'Développeur informatique',
                'meta.description' => 'Je suis Jules, un étudiant en informatique français. Découvrez-en plus sur moi, mon travail et mes projets sur ce site web.',
            ],
            'en' => [
                'nav.home' => 'Home',
                'nav.about' => 'About',
                'nav.contact' => 'Contact',
                'footer.copyright' => '© 2025 Jules Vialas, all rights reserved.',
                'home.title' => 'IT Developer',
                'meta.description' => 'I\'m Jules, a French computer science student. Learn more about me, my work and my projects on this website.',
            ]
        ];
    }
}