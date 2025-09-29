<?php

namespace Celcat;

class IcsBuilder {

    private string $timezone = 'Europe/Paris';

    public function buildIcs(array $events): string {
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//VotreAppli//CELCAT2ICS//FR\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:PUBLISH\r\n";

        foreach ($events as $ev) {
            $start = $this->formatDate($ev['start'] ?? '');
            $end   = $this->formatDate($ev['end'] ?? '');
            if (!$start || !$end) continue; // Ignore les événements sans date

            $uid   = ($ev['id'] ?? uniqid()) . "@votresite";
            $desc  = $this->clean($ev['description'] ?? '');
            $summary = $this->clean($ev['eventCategory'] ?? 'Cours');
            $location = $this->clean(implode(',', $ev['sites'] ?? []));

            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:$uid\r\n";
            $ics .= "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n";
            $ics .= "DTSTART;TZID={$this->timezone}:$start\r\n";
            $ics .= "DTEND;TZID={$this->timezone}:$end\r\n";
            $ics .= "SUMMARY:$summary\r\n";
            if ($location) $ics .= "LOCATION:$location\r\n";
            if ($desc) $ics .= "DESCRIPTION:$desc\r\n";
            $ics .= "END:VEVENT\r\n";
        }

        $ics .= "END:VCALENDAR\r\n";
        return $ics;
    }

    /**
     * Formate une date ISO pour ICS
     */
    private function formatDate(string $iso): string {
        if (!$iso) return '';
        try {
            $dt = new \DateTime($iso, new \DateTimeZone($this->timezone));
            return $dt->format('Ymd\THis');
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Nettoie et échappe le texte pour ICS
     */
    private function clean(string $text): string {
        $text = html_entity_decode(strip_tags($text));
        // Échapper \ , ; et remplacer les retours à la ligne par \n
        $text = str_replace(['\\', ',', ';', "\r", "\n"], ['\\\\', '\,', '\;', '', '\\n'], $text);
        return $text;
    }
}
?>