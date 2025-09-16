# 🌐 vialasjules.com

> Site web personnel de Jules Vialas - Portfolio et présentation professionnelle

[![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=flat-square&logo=php)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.8-7952B3?style=flat-square&logo=bootstrap)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

## 📋 Table des matières

- [À propos](#-à-propos)
- [Fonctionnalités](#-fonctionnalités)
- [Structure du projet](#-structure-du-projet)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Utilisation](#-utilisation)
- [Architecture](#-architecture)
- [Technologies](#-technologies)
- [Déploiement](#-déploiement)
- [Contribution](#-contribution)
- [Licence](#-licence)

## 🎯 À propos

Site web personnel développé en PHP vanilla avec une architecture MVC simple. Le site présente mon profil professionnel et mes projets avec un système multilingue français/anglais.

### Caractéristiques principales

- **Multilingue** : Support français/anglais avec persistance
- **Responsive** : Interface adaptative mobile/desktop
- **Performance** : Code optimisé et structure légère
- **SEO** : Optimisé pour les moteurs de recherche
- **Sécurité** : Séparation public/privé, validation des entrées

## ✨ Fonctionnalités

### 🌍 Système multilingue
- Détection automatique de la langue
- Persistance via sessions et cookies
- Changement de langue en temps réel
- URLs localisées

### 📱 Interface utilisateur
- Design responsive Bootstrap 5
- Navigation intuitive
- Animations fluides
- Accessibilité optimisée

### 🔧 Architecture technique
- Routeur personnalisé avec paramètres
- Système de vues modulaire
- Service de traduction centralisé
- Code documenté avec PHPDoc

## 📁 Structure du projet

```
vialasjules.com/
├── public/                     # Point d'entrée web
│   ├── index.php              # Bootstrap de l'application
│   ├── .htaccess              # Configuration Apache
│   └── assets/                # Ressources publiques
│       ├── css/
│       │   └── style.css      # Styles personnalisés
│       ├── js/
│       │   └── app.js         # JavaScript personnalisé
│       └── images/
│           └── logo.ico       # Favicon
├── src/                       # Code source de l'application
│   ├── Controllers/           # Contrôleurs MVC
│   │   └── HomeController.php
│   ├── Services/              # Services métier
│   │   ├── Language.php       # Gestion multilingue
│   │   └── Router.php         # Routeur HTTP
│   └── Views/                 # Templates et vues
│       ├── components/        # Composants réutilisables
│       │   ├── header.php
│       │   └── footer.php
│       └── layouts/           # Templates de page
│           └── home.php
├── README.md                  # Documentation
└── .htaccess                  # Configuration serveur
```

## 🚀 Installation

### Prérequis

- **PHP 8.0+** avec extensions :
  - `session`
  - `json`
- **Serveur web** : Apache/Nginx
- **Git** pour le clonage

### Installation locale

1. **Cloner le repository**
   ```bash
   git clone https://github.com/JulesVialas/vialasjules.com.git
   cd vialasjules.com
   ```

2. **Configuration du serveur web**
   
   **Avec XAMPP/WAMP :**
   ```bash
   # Copier le projet dans le dossier web
   cp -r . /path/to/xampp/htdocs/vialasjules
   ```
   
   **Avec serveur PHP intégré :**
   ```bash
   # Démarrer depuis le dossier public/
   cd public
   php -S localhost:8000
   ```

3. **Configuration Apache** (optionnel)
   ```apache
   <VirtualHost *:80>
       DocumentRoot "/path/to/vialasjules.com/public"
       ServerName vialasjules.local
       <Directory "/path/to/vialasjules.com/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```

## ⚙️ Configuration

### Variables d'environnement

Le projet fonctionne sans configuration particulière. Les paramètres par défaut :

- **Langue par défaut** : Français (`fr`)
- **Langues supportées** : `fr`, `en`
- **Durée du cookie** : 30 jours
- **Point d'entrée** : `public/index.php`

### Personnalisation

**Ajouter une nouvelle langue :**
```php
// Dans src/Services/Language.php
private static function loadTranslations(): void {
    self::$translations = [
        'fr' => [...],
        'en' => [...],
        'es' => [  // Nouvelle langue
            'nav.home' => 'Inicio',
            // ...
        ]
    ];
}
```

**Ajouter une nouvelle route :**
```php
// Dans public/index.php
$router->get('/about', [new AboutController(), 'get']);
$router->get('/contact', [new ContactController(), 'get']);
```

## 🎮 Utilisation

### Accès au site
- **Local** : `http://localhost:8000` ou `http://vialasjules.local`
- **Production** : `https://vialasjules.com`

### Changement de langue
- Cliquer sur le drapeau dans la navigation
- URL directe : `?lang=en` ou `?lang=fr`
- La préférence est sauvegardée automatiquement

### Navigation
- **Accueil** : `/` - Page principale
- **À propos** : `/about` - Présentation détaillée
- **Contact** : `/contact` - Formulaire de contact

## 🏗️ Architecture

### Pattern MVC

```mermaid
graph TB
    A[public/index.php] --> B[Router]
    B --> C[Controllers]
    C --> D[Views]
    D --> E[Components]
    
    F[Services] --> C
    F --> D
    
    subgraph "Services"
        F1[Language]
        F2[Router]
    end
    
    subgraph "Views"
        D1[layouts/]
        D2[components/]
    end
```

### Flux de requête

1. **Point d'entrée** : `public/index.php`
2. **Initialisation** : Session, Language, Router
3. **Routage** : Analyse de l'URI et méthode HTTP
4. **Contrôleur** : Exécution de la logique métier
5. **Vue** : Rendu du template avec données
6. **Réponse** : HTML généré envoyé au navigateur

### Services principaux

- **Language** : Gestion multilingue et traductions
- **Router** : Routage HTTP avec paramètres dynamiques
- **Controllers** : Logique métier et coordination

## 🛠️ Technologies

### Backend
- **PHP 8.0+** - Langage principal
- **Architecture MVC** - Pattern de conception
- **PSR-4** - Autoloading et namespaces
- **PHPDoc** - Documentation du code

### Frontend
- **Bootstrap 5.3.8** - Framework CSS
- **HTML5 sémantique** - Structure
- **JavaScript vanilla** - Interactions
- **CSS3** - Styles personnalisés

### Outils et standards
- **Git** - Versioning
- **Apache/Nginx** - Serveur web
- **Responsive design** - Adaptabilité mobile
- **SEO optimized** - Référencement

## 🚢 Déploiement

### Déploiement automatique

**Via Git :**
```bash
# Sur le serveur de production
git clone https://github.com/JulesVialas/vialasjules.com.git
cd vialasjules.com

# Configuration du virtual host vers public/
# Redémarrage du serveur web
```

**Via FTP :**
```bash
# Upload de tous les fichiers
# Configuration du document root vers public/
```

### Configuration production

1. **Document Root** : Pointer vers `public/`
2. **PHP** : Version 8.0+ recommandée
3. **Apache modules** : `mod_rewrite` activé
4. **Permissions** : 755 pour dossiers, 644 pour fichiers

### Optimisations production

- **Minification** : CSS/JS si nécessaire
- **Cache** : Headers HTTP appropriés
- **Compression** : Gzip activé
- **HTTPS** : Certificat SSL configuré

## 🤝 Contribution

### Développement

1. **Fork** du repository
2. **Créer une branche** : `git checkout -b feature/nouvelle-fonctionnalite`
3. **Développer** avec tests
4. **Commit** : `git commit -m "feat: description de la fonctionnalité"`
5. **Push** : `git push origin feature/nouvelle-fonctionnalite`
6. **Pull Request** avec description détaillée

### Standards de code

- **PSR-4** : Autoloading
- **PSR-12** : Style de code
- **PHPDoc** : Documentation obligatoire
- **Tests** : Couverture recommandée

### Issues et bugs

Utiliser les [GitHub Issues](https://github.com/JulesVialas/vialasjules.com/issues) pour :
- 🐛 Signaler des bugs
- 💡 Proposer des améliorations
- 📖 Demander de la documentation

## 📄 Licence

Ce projet est sous licence **MIT**. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## 👨‍💻 Auteur

**Jules Vialas**
- 🌐 Website : [vialasjules.com](https://vialasjules.com)
- 💼 LinkedIn : [julesvialas](https://linkedin.com/in/julesvialas)
- 🐱 GitHub : [JulesVialas](https://github.com/JulesVialas)

---

<div align="center">
  <p>Développé avec ❤️ par Jules Vialas</p>
  <p><small>Dernière mise à jour : Septembre 2025</small></p>
</div>