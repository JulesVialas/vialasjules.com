# Configuration et Standards

## Standards de développement

### PHP
- Version minimum : PHP 8.1+
- Standards : PSR-4 (Autoloading), PSR-12 (Coding Style)
- Type declarations : Strict mode activé (`declare(strict_types=1)`)
- Gestion d'erreurs : Exceptions appropriées

### JavaScript
- Standard : ES6+ avec compatibilité moderne
- Fonctions : Arrow functions, const/let, template literals
- DOM : addEventListener, querySelector
- Async : Pas de callbacks imbriqués

### CSS
- Méthodologie : BEM-like naming
- Variables CSS : Utilisées pour la consistance
- Responsive : Mobile-first approach
- Performance : Éviter les règles redondantes

## Structure des fichiers

```
public/          # Dossier public accessible via web
├── index.php    # Point d'entrée unique
└── assets/      # Assets statiques (CSS, JS, images)

src/             # Code source PHP
├── Autoloader.php     # Autoloader PSR-4 custom
├── Controllers/       # Logique de contrôleur
├── Services/         # Services réutilisables
└── Views/           # Templates et vues
```

## Conventions de nommage

### PHP
- Classes : `PascalCase` (ex: `HomeController`)
- Méthodes : `camelCase` (ex: `getCurrentLanguage`)
- Constantes : `UPPER_SNAKE_CASE` (ex: `DEFAULT_LANGUAGE`)
- Variables : `camelCase` (ex: `$currentLanguage`)

### CSS
- Classes : `kebab-case` (ex: `.main-content`)
- Variables : `--kebab-case` (ex: `--accent-color`)

### JavaScript
- Variables/Fonctions : `camelCase` (ex: `initializeNavigation`)
- Constantes : `UPPER_SNAKE_CASE` (ex: `SUPPORTED_METHODS`)

## Sécurité

### Protection XSS
- Échapper toutes les sorties avec `htmlspecialchars()`
- Utiliser les fonctions de PHP appropriées pour les URLs

### Validation des entrées
- Valider toutes les données utilisateur
- Utiliser `filter_var()` pour la validation
- Nettoyer les paramètres GET/POST

### Sessions
- Configuration sécurisée des cookies
- Régénération d'ID de session
- Timeout approprié

## Performance

### PHP
- Autoloader efficace
- Pas de `require` multiples
- Utilisation du cache OPcache en production

### Frontend
- CSS/JS minifiés en production
- Images optimisées
- Lazy loading si nécessaire

### Caching
- Headers de cache appropriés
- Versioning des assets pour invalidation