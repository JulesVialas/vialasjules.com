<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Email Service
 * Handles email sending functionality with template support
 */
class EmailService
{
    private const DEFAULT_FROM_EMAIL = 'noreply@vialasjules.com';
    
    public function __construct(
        private string $fromEmail = self::DEFAULT_FROM_EMAIL
    ) {}
    
    /**
     * Send a contact form email
     */
    public function sendContactEmail(
        string $recipientEmail,
        array $contactData,
        string $language = 'fr'
    ): bool {
        $subject = $this->buildContactSubject($contactData['fullname']);
        $body = $this->buildContactEmailBody($contactData, $language);
        $headers = $this->buildEmailHeaders($contactData['email']);
        
        return $this->sendEmail($recipientEmail, $subject, $body, $headers);
    }
    
    /**
     * Send a generic email
     */
    public function sendEmail(
        string $to,
        string $subject,
        string $body,
        string $headers = ''
    ): bool {
        if (empty($headers)) {
            $headers = $this->buildDefaultHeaders();
        }
        
        return mail($to, $subject, $body, $headers);
    }
    
    /**
     * Build contact email subject
     */
    private function buildContactSubject(string $senderName): string
    {
        return 'Nouveau message de contact - ' . $senderName;
    }
    
    /**
     * Build contact email body
     */
    private function buildContactEmailBody(array $data, string $language): string
    {
        $timestamp = date('Y-m-d H:i:s');
        
        if ($language === 'fr') {
            return "Nouveau message de contact reçu le {$timestamp}\n\n" .
                   "Nom: {$data['fullname']}\n" .
                   "Email: {$data['email']}\n\n" .
                   "Message:\n{$data['message']}\n\n" .
                   "---\nEnvoyé depuis le site vialasjules.com";
        } else {
            return "New contact message received on {$timestamp}\n\n" .
                   "Name: {$data['fullname']}\n" .
                   "Email: {$data['email']}\n\n" .
                   "Message:\n{$data['message']}\n\n" .
                   "---\nSent from vialasjules.com";
        }
    }
    
    /**
     * Build email headers for contact form
     */
    private function buildEmailHeaders(string $replyToEmail): string
    {
        return "From: {$this->fromEmail}\r\n" .
               "Reply-To: {$replyToEmail}\r\n" .
               "Content-Type: text/plain; charset=UTF-8\r\n" .
               "X-Mailer: PHP/" . phpversion();
    }
    
    /**
     * Build default email headers
     */
    private function buildDefaultHeaders(): string
    {
        return "From: {$this->fromEmail}\r\n" .
               "Content-Type: text/plain; charset=UTF-8\r\n" .
               "X-Mailer: PHP/" . phpversion();
    }
    
    /**
     * Validate email address
     */
    public function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}