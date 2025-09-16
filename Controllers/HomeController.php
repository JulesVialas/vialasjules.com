<?php

namespace Controllers;
class HomeController {
    public function get() {
        include __DIR__ . '/../Views/home.php';
    }
}