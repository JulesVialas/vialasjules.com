<?php
namespace App\Controllers;

use Celcat\CelcatService;
use Celcat\IcsBuilder;

class EmploiDuTempsControleur
{
    /**
     * Affiche le formulaire d'export ou génère l'ICS selon le paramètre
     */
    public function convert(): void
    {
        if (!isset($_GET['celcat_url']) || empty($_GET['celcat_url'])) {
            $this->renderView('layouts/emploi-du-temps');
            return;
        }

        $celcatUrl = $_GET['celcat_url'];

        try {
            // Extraction des paramètres depuis l'URL HTML du calendrier
            $matches = [];
            preg_match('/fid0=([0-9]+)/', $celcatUrl, $matches);
            $fid = $matches[1] ?? null;
            preg_match('/dt=([0-9\-]+)/', $celcatUrl, $matches);
            $dt = $matches[1] ?? date('Y-m-01');

            if (!$fid) {
                http_response_code(400);
                echo "Impossible d'extraire le paramètre fid0 de l'URL.";
                return;
            }

            $start = $dt;
            $end = date('Y-m-t', strtotime($dt));

            // Récupération des identifiants via fichier de config
            require_once __DIR__ . '/../config.celcat.php';
            $username = defined('CELCAT_USERNAME') ? CELCAT_USERNAME : '';
            $password = defined('CELCAT_PASSWORD') ? CELCAT_PASSWORD : '';

            if (empty($username) || empty($password)) {
                http_response_code(401);
                echo "Identifiants CELCAT manquants. Vérifiez src/config.celcat.php.";
                return;
            }

            $service = new \Celcat\CelcatService($username, $password);
            $events = $service->fetchEvents($fid, $start, $end);

            if (!is_array($events)) {
                http_response_code(400);
                echo "Format de données invalide (JSON attendu).";
                return;
            }

            $icsBuilder = new IcsBuilder();
            $ics = $icsBuilder->buildIcs($events);

            header('Content-Type: text/calendar; charset=utf-8');
            echo $ics;
        } catch (\Exception $e) {
            http_response_code(500);
            echo "Erreur : " . $e->getMessage() . "\n";
            echo "<pre>" . print_r($e, true) . "</pre>";
        }
    }

    /**
     * Affiche le formulaire d'export (GET sans paramètre)
     */
    public function form(): void
    {
        $this->renderView('layouts/emploi-du-temps');
    }

    private function renderView(string $viewPath): void
    {
        $fullPath = __DIR__ . '/../Views/' . $viewPath . '.php';
        if (!file_exists($fullPath)) {
            throw new \InvalidArgumentException("View file not found: {$fullPath}");
        }
        include $fullPath;
    }
}
