<?php

namespace Celcat;

class CelcatService
{
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Récupère les événements CELCAT pour un étudiant ou ressource donnée
     */
    public function fetchEvents(string $fid, string $start = null, string $end = null): array
    {
        $start = $start ?? date('Y-m-01');
        $end   = $end   ?? date('Y-m-t');

        $url = "https://edt.univ-tlse3.fr/calendar/Home/GetCalendarData";
        $postData = http_build_query([
            'start' => $start,
            'end' => $end,
            'resType' => 104,
            'calView' => 'month',
            'federationIds[]' => $fid,
            'colourScheme' => 3
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With: XMLHttpRequest',
            'Accept: application/json, text/javascript, */*; q=0.01',
            'Referer: https://edt.univ-tlse3.fr/calendar/cal?vt=month&dt='.$start.'&et=student&fid0='.$fid,
            'Origin: https://edt.univ-tlse3.fr',
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0 Safari/605.1.15'
        ]);

        // Si login/mot de passe fournis, on utilise les cookies, sinon mode public
        if (!empty($this->username) && !empty($this->password)) {
            $cookies = $this->loginAndGetCookies();
            curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        }

        $response = curl_exec($ch);
        if ($response === false) {
            throw new \Exception('Erreur cURL : ' . curl_error($ch));
        }
        curl_close($ch);

        $data = json_decode($response, true);
        return $data ?? [];
    }

    /**
     * Simule la connexion pour récupérer les cookies de session
     */
    private function loginAndGetCookies(): string
    {
        // URL du login CELCAT (ou SSO selon ton université)
        $loginUrl = "https://edt.univ-tlse3.fr/account/login";

        $postData = http_build_query([
            'username' => $this->username,
            'password' => $this->password,
            'returnUrl' => '/calendar'
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $loginUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true); // pour récupérer les headers
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new \Exception('Erreur login cURL : ' . curl_error($ch));
        }

        // Extraire les cookies de session depuis les headers
        preg_match_all('/Set-Cookie: ([^;]+);/', $response, $matches);
        curl_close($ch);

        if (empty($matches[1])) {
            throw new \Exception('Impossible de récupérer les cookies de session');
        }

        return implode('; ', $matches[1]);
    }
}
?>