<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\Language;
use App\Services\EmailService;

/**
 * Contact Controller
 * Handles contact form submissions
 */
class ContactController
{
    private const RECIPIENT_EMAIL = 'jules.vialas@gmail.com';
    
    private EmailService $emailService;
    
    public function __construct()
    {
        $this->emailService = new EmailService();
    }
    
    public function submitForm(): void
    {
        // Check if request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendResponse(405, 'error', 'Method not allowed');
            return;
        }
        
        // Validate and sanitize input
        $contactData = $this->validateAndSanitizeInput();
        if (!$contactData) {
            $this->sendResponse(400, 'error', Language::get('contact.error.validation'));
            return;
        }
        
        // Send email using EmailService
        $success = $this->emailService->sendContactEmail(
            self::RECIPIENT_EMAIL,
            $contactData,
            Language::getCurrentLanguage()
        );
        
        if ($success) {
            $this->sendResponse(200, 'success', Language::get('contact.success.sent'));
        } else {
            $this->sendResponse(500, 'error', Language::get('contact.error.sending'));
        }
    }
    
    private function validateAndSanitizeInput(): ?array
    {
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        // Basic validation
        if (empty($fullname) || empty($email) || empty($message)) {
            return null;
        }
        
        if (!$this->emailService->isValidEmail($email)) {
            return null;
        }
        
        if (strlen($fullname) > 100 || strlen($message) > 2000) {
            return null;
        }
        
        // Sanitize data
        return [
            'fullname' => htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($email, FILTER_SANITIZE_EMAIL),
            'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
        ];
    }
    
    private function sendResponse(int $code, string $status, string $message): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        
        echo json_encode([
            'status' => $status,
            'message' => $message
        ]);
    }
}