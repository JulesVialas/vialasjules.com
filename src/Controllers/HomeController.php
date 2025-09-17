<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * Home Controller
 * Handles the main page display and related actions
 */
class HomeController
{
    public function index(): void
    {
        $this->renderView('layouts/home');
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