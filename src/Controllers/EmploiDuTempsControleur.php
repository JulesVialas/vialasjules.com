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
            // On accepte l'URL HTML du calendrier et on extrait les paramètres
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

            // Calcul de la date de fin (fin du mois courant)
            $start = $dt;
            $end = date('Y-m-t', strtotime($dt));

            // Construction des paramètres POST pour GetCalendarData
            $postData = http_build_query([
                'start' => $start,
                'end' => $end,
                'resType' => 104,
                'calView' => 'month',
                'federationIds[]' => $fid,
                'colourScheme' => 3
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://edt.univ-tlse3.fr/calendar/Home/GetCalendarData');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'X-Requested-With: XMLHttpRequest',
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Referer: ' . $celcatUrl,
                'Origin: https://edt.univ-tlse3.fr',
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0 Safari/605.1.15'
            ]);

            $json = curl_exec($ch);
            if ($json === false) {
                http_response_code(400);
                echo "Erreur lors de la récupération des données CELCAT : " . curl_error($ch);
                curl_close($ch);
                return;
            }
            curl_close($ch);

            $events = json_decode($json, true);
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
