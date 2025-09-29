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
            // Affiche le formulaire si pas d'URL
            $this->renderView('layouts/emploi-du-temps');
            return;
        }

        $celcatUrl = $_GET['celcat_url'];

        // Mode public : on tente de récupérer le JSON directement depuis l'URL fournie
        try {
            // Si l'URL est un endpoint JSON (GetCalendarData), on fait un GET direct
            if (strpos($celcatUrl, 'GetCalendarData') !== false) {
                $json = file_get_contents($celcatUrl);
                if ($json === false) {
                    http_response_code(400);
                    echo "Impossible de récupérer les données depuis l'URL fournie.";
                    return;
                }
                $events = json_decode($json, true);
                if (!is_array($events)) {
                    http_response_code(400);
                    echo "Format de données invalide (JSON attendu).";
                    return;
                }
            } else {
                // Si l'URL est celle du calendrier HTML, on affiche une erreur explicite
                http_response_code(400);
                echo "L'URL fournie doit pointer vers le endpoint JSON (GetCalendarData).";
                return;
            }

            $icsBuilder = new IcsBuilder();
            $ics = $icsBuilder->buildIcs($events);

            header('Content-Type: text/calendar; charset=utf-8');
            echo $ics;
        } catch (\Exception $e) {
            http_response_code(500);
            echo "Erreur : " . $e->getMessage();
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
