<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Language Service
 * Handles multilingual support for French and English with persistence
 */
class Language
{
    private const SUPPORTED_LANGUAGES = ['fr', 'en'];
    private const DEFAULT_LANGUAGE = 'fr';
    private const COOKIE_NAME = 'site_lang';
    private const COOKIE_LIFETIME = 86400 * 30; // 30 days
    
    private static string $currentLanguage = self::DEFAULT_LANGUAGE;
    private static array $translations = [];
    
    public static function init(): void
    {
        // Determine language from various sources
        $requestedLang = $_GET['lang'] ?? $_SESSION['lang'] ?? $_COOKIE[self::COOKIE_NAME] ?? self::DEFAULT_LANGUAGE;
        
        // Validate and sanitize language
        self::$currentLanguage = self::isValidLanguage($requestedLang) 
            ? $requestedLang 
            : self::DEFAULT_LANGUAGE;
        
        // Persist language choice
        $_SESSION['lang'] = self::$currentLanguage;
        setcookie(
            self::COOKIE_NAME, 
            self::$currentLanguage, 
            time() + self::COOKIE_LIFETIME, 
            '/',
            '',
            false,
            true // httponly
        );
        
        self::loadTranslations();
    }
    
    public static function get(string $key): string
    {
        return self::$translations[self::$currentLanguage][$key] ?? $key;
    }
    
    public static function getCurrentLanguage(): string
    {
        return self::$currentLanguage;
    }
    
    public static function getSupportedLanguages(): array
    {
        return self::SUPPORTED_LANGUAGES;
    }
    
    private static function isValidLanguage(string $language): bool
    {
        return in_array($language, self::SUPPORTED_LANGUAGES, true);
    }
    
    
    private static function loadTranslations(): void
    {
        self::$translations = [
            'fr' => [
                'nav.about' => 'À Propos',
                'nav.resume' => 'CV',
                'nav.contact' => 'Contact',
                'title.developer' => 'Développeur informatique',
                'title.show_contacts' => 'Afficher les contacts',
                'contact.email' => 'Email',
                'contact.phone' => 'Téléphone',
                'contact.birthday' => 'Anniversaire',
                'contact.location' => 'Localisation',
                'about.title' => 'À propos de moi',
                'about.description' => 'Je suis Jules Vialas, étudiant en Licence MIAGE à l\'Université de Toulouse. Passionné par le développement informatique et les nouvelles technologies, je me spécialise dans la création d\'applications web et mobiles. Mon parcours m\'a permis d\'acquérir une solide expérience en développement full-stack, notamment à travers mes stages chez C1Partner et Subterra. Que vous soyez un particulier ayant besoin d\'une présence web ou une entreprise cherchant à optimiser ses processus, j\'offre des services informatiques adaptés à votre budget et à vos ambitions.',
                'resume.title' => 'CV',
                'contact.title' => 'Contact',
                'education.title' => 'Formation',
                'experience.title' => 'Expérience',
                'services.title' => 'Ce que je fais',
                'service.webdesign.title' => 'Conception Web',
                'service.webdesign.desc' => 'Solutions de design web modernes et professionnelles adaptées à l\'identité de votre marque.',
                'service.webdev.title' => 'Développement Web',
                'service.webdev.desc' => 'Développement de haute qualité de sites web et applications web avec des technologies modernes.',
                'service.mobile.title' => 'Applications Mobiles',
                'service.mobile.desc' => 'Développement professionnel d\'applications mobiles pour les plateformes iOS et Android.',
                'service.java.title' => 'Développement Java',
                'service.java.desc' => 'Applications Java de niveau entreprise et développement de systèmes backend.',
                'service.domotique.title' => 'Domotique',
                'service.domotique.desc' => 'Solutions de maison intelligente et systèmes IoT pour l\'automatisation de la vie moderne.',
                'clients.title' => 'Clients',
                'contact.form_title' => 'Formulaire de contact',
                'contact.send' => 'Envoyer le message',
                'contact.fullname' => 'Nom complet',
                'contact.email_address' => 'Adresse email',
                'contact.message' => 'Votre message',
                'contact.success.sent' => 'Votre message a été envoyé avec succès !',
                'contact.error.validation' => 'Veuillez remplir tous les champs correctement.',
                'contact.error.sending' => 'Erreur lors de l\'envoi du message. Veuillez réessayer.',
                'date.november' => 'Novembre',
                'lang.switch' => 'English',
                // Education
                'edu.miage.title' => 'Licence MIAGE - Université de Toulouse',
                'edu.miage.desc' => 'Programme avancé en informatique de gestion axé sur les applications informatiques et métiers, combinant compétences techniques et expertise managériale.',
                'edu.but.title' => 'BUT Informatique - IUT Rodez',
                'edu.but.desc' => 'Diplôme en informatique avec focus sur le développement logiciel, la gestion de bases de données et les technologies de programmation modernes.',
                'edu.bac.title' => 'Baccalauréat Général - Lycée Pierre d\'Aragon',
                'edu.bac.desc' => 'Baccalauréat général scientifique avec focus sur les sciences et mathématiques, fournissant des bases solides pour les études en informatique.',
                // Experience
                'exp.c1.cdd.title' => 'Développeur Full Stack CDD - C1Partner',
                'exp.c1.cdd.desc' => 'Conception et développement d\'un module de gestion des congés entièrement intégré au CMS interne. Création d\'interfaces conviviales avec HTML, CSS et JavaScript connectées à un backend PHP/MySQL. Amélioration de l\'efficacité administrative en automatisant le workflow de demandes et validations.',
                'exp.c1.stage.title' => 'Stage Développeur Full Stack - C1Partner',
                'exp.c1.stage.desc' => 'Développement d\'un module complet de gestion des frais pour 3 départements avec 50 utilisateurs. Conception et implémentation de solutions full-stack utilisant PHP, HTML, CSS et JavaScript pour rationaliser le processus de reporting des frais.',
                'exp.subterra.title' => 'Stage Développeur IT - Subterra',
                'exp.subterra.desc' => 'Gestion du support et maintenance complète de l\'infrastructure IT pour 2 sites d\'inspection avec 50 appareils réseau. Supervision des installations réseau critiques, configurations système et maintenance matérielle pour assurer la performance optimale des systèmes robotiques d\'inspection.',
            ],
            'en' => [
                'nav.about' => 'About',
                'nav.resume' => 'Resume',
                'nav.contact' => 'Contact',
                'title.developer' => 'IT developer',
                'title.show_contacts' => 'Show Contacts',
                'contact.email' => 'Email',
                'contact.phone' => 'Phone',
                'contact.birthday' => 'Birthday',
                'contact.location' => 'Location',
                'about.title' => 'About me',
                'about.description' => 'I\'m Jules Vialas, a MIAGE Bachelor\'s student at the University of Toulouse. Passionate about software development and new technologies, I specialize in creating web and mobile applications. My journey has allowed me to gain solid experience in full-stack development, particularly through my internships at C1Partner and Subterra. Whether you\'re an individual needing a web presence or a business looking to optimize your processes, I offer IT services adapted to your budget and ambitions.',
                'resume.title' => 'Resume',
                'contact.title' => 'Contact',
                'education.title' => 'Education',
                'experience.title' => 'Experience',
                'services.title' => 'What I\'m doing',
                'service.webdesign.title' => 'Web Design',
                'service.webdesign.desc' => 'Modern and professional web design solutions tailored to your brand identity.',
                'service.webdev.title' => 'Web Development',
                'service.webdev.desc' => 'High-quality development of websites and web applications using modern technologies.',
                'service.mobile.title' => 'Mobile Applications',
                'service.mobile.desc' => 'Professional development of mobile applications for iOS and Android platforms.',
                'service.java.title' => 'Java Development',
                'service.java.desc' => 'Enterprise-grade Java applications and backend systems development.',
                'service.domotique.title' => 'Home Automation',
                'service.domotique.desc' => 'Smart home solutions and IoT systems for modern living automation.',
                'clients.title' => 'Clients',
                'contact.form_title' => 'Contact Form',
                'contact.send' => 'Send Message',
                'contact.fullname' => 'Full name',
                'contact.email_address' => 'Email address',
                'contact.message' => 'Your Message',
                'contact.success.sent' => 'Your message has been sent successfully!',
                'contact.error.validation' => 'Please fill in all fields correctly.',
                'contact.error.sending' => 'Error sending message. Please try again.',
                'date.november' => 'November',
                'lang.switch' => 'Français',
                // Education
                'edu.miage.title' => 'MIAGE License - University of Toulouse',
                'edu.miage.desc' => 'Advanced computer science program focused on IT management and business applications, combining technical skills with management expertise.',
                'edu.but.title' => 'BUT Computer Science - IUT Rodez',
                'edu.but.desc' => 'Bachelor\'s degree in Computer Science with focus on software development, database management, and modern programming technologies.',
                'edu.bac.title' => 'General Baccalaureate - Pierre d\'Aragon High School',
                'edu.bac.desc' => 'General high school diploma with a focus on science and mathematics, providing strong foundations for computer science studies.',
                // Experience
                'exp.c1.cdd.title' => 'Fixed-term Full Stack Developer - C1Partner',
                'exp.c1.cdd.desc' => 'Designed and developed a leave management module fully integrated into the internal CMS. Built user-friendly interfaces with HTML, CSS and JavaScript connected to a PHP/MySQL backend. Improved administrative efficiency by automating the request and validation workflow.',
                'exp.c1.stage.title' => 'Full Stack Developer Internship - C1Partner',
                'exp.c1.stage.desc' => 'Developed a comprehensive expense management module for 3 company departments with 50 users. Designed and implemented full-stack solutions using PHP, HTML, CSS, and JavaScript to streamline expense reporting process.',
                'exp.subterra.title' => 'IT Developer Internship - Subterra',
                'exp.subterra.desc' => 'Managed comprehensive IT infrastructure support and maintenance for 2 inspection sites with 50 networked devices. Oversaw critical network installations, system configurations, and hardware maintenance to ensure optimal performance of inspection robotics.',
            ]
        ];
    }
}