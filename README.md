# 🎓 Workshop : Gestion d'Erreurs en PHP

Un mini-workshop pédagogique pour comprendre l'évolution des techniques de gestion d'erreurs en PHP, de la pire pratique (echo + die) à la meilleure (exceptions).

## 📚 Objectif

Ce workshop démontre concrètement pourquoi les exceptions sont la méthode recommandée pour gérer les erreurs en PHP, en montrant les problèmes causés par les approches alternatives.

## 🎯 Les 3 Approches

### 1️⃣ Approche Naïve : `echo` + `die()`

**Exemple :**
```php
function getUserData($userId) {
    if (!isset($users[$userId])) {
        echo "Erreur: User not found";
        die();
    }
    return $users[$userId];
}
```

**Problèmes :**
- ❌ Casse la structure HTML (balises non fermées)
- ❌ Produit du JSON invalide
- ❌ Arrêt brutal de l'exécution
- ❌ Impossible de gérer l'erreur proprement

### 2️⃣ Approche Intermédiaire : Erreur dans un tableau

**Exemple :**
```php
function getUserData($userId) {
    if (!isset($users[$userId])) {
        return ['error' => 'User not found'];
    }
    return ['user' => $users[$userId]];
}

// Utilisation
$result = getUserData(1);
if (isset($result['error'])) {
    // Gérer l'erreur
} else {
    // Utiliser $result['user']
}
```

**Problèmes :**
- ⚠️ Type de retour imprévisible (données ou erreur)
- ⚠️ Code verbeux (if/else partout)
- ⚠️ Risque d'oublier la vérification
- ⚠️ Pas de code HTTP approprié pour les APIs

**Améliorations :**
- ✅ HTML/JSON reste valide
- ✅ Pas de die()

### 3️⃣ Bonne Pratique : Exceptions

**Exemple :**
```php
class UserNotFoundException extends Exception {}

function getUserData($userId) {
    if (!isset($users[$userId])) {
        throw new UserNotFoundException("User not found");
    }
    return $users[$userId]; // Type toujours prévisible
}

// Utilisation
try {
    $user = getUserData(1);
    // Utiliser $user directement
} catch (UserNotFoundException $e) {
    // Gestion d'erreur centralisée
}
```

**Avantages :**
- ✅ Séparation claire code normal / code erreur
- ✅ Type de retour prévisible
- ✅ Gestion d'erreur obligatoire
- ✅ Code propre et maintenable
- ✅ Codes HTTP appropriés (404, 500...)
- ✅ Différenciation des types d'erreurs possible

## 🚀 Démarrage Rapide

### Prérequis

- PHP 7.4 ou supérieur
- Un serveur web (Apache, Nginx) ou le serveur intégré de PHP

### Installation

1. Clonez ce dépôt :
```bash
git clone <url-du-repo>
cd workshop-exceptions
```

2. Démarrez un serveur PHP :
```bash
php -S localhost:8000
```

3. Ouvrez votre navigateur :
```
http://localhost:8000/demo/
```

## 📂 Structure du Projet

```
.
├── README.md                    # Ce fichier
├── 01-bad-approach/
│   ├── lib.php                 # Code métier avec echo + die
│   ├── html-example.php        # Démo HTML cassée
│   └── api-example.php         # Démo API JSON cassée
├── 02-intermediate/
│   ├── lib.php                 # Code métier retournant erreur dans tableau
│   ├── html-example.php        # Démo HTML avec if/else
│   └── api-example.php         # Démo API avec vérifications
├── 03-exceptions/
│   ├── lib.php                 # Code métier avec exceptions
│   ├── html-example.php        # Démo HTML avec try-catch
│   └── api-example.php         # Démo API professionnelle
└── demo/
    ├── index.php               # Interface interactive du workshop
    └── styles.css              # Styles
```

## 🎮 Utilisation

### Option 1 : Interface Interactive (Recommandé)

Accédez à la démo interactive pour voir les 3 approches côte à côte :

```
http://localhost:8000/demo/
```

Cette interface vous permet de :
- Naviguer entre les 3 approches
- Voir les exemples HTML et JSON pour chaque approche
- Comparer visuellement les résultats
- Lire le code source commenté

### Option 2 : Exemples Individuels

Vous pouvez aussi accéder directement à chaque exemple :

**Approche 1 (echo + die) :**
- HTML : `http://localhost:8000/01-bad-approach/html-example.php`
- API : `http://localhost:8000/01-bad-approach/api-example.php`

**Approche 2 (tableau) :**
- HTML : `http://localhost:8000/02-intermediate/html-example.php`
- API : `http://localhost:8000/02-intermediate/api-example.php`

**Approche 3 (exceptions) :**
- HTML : `http://localhost:8000/03-exceptions/html-example.php`
- API : `http://localhost:8000/03-exceptions/api-example.php`

## 💡 Points Clés à Retenir

### 1. N'utilisez JAMAIS echo + die() en production
- Casse le format de sortie (HTML/JSON)
- Impossible de gérer les erreurs proprement
- Expérience utilisateur désastreuse

### 2. Évitez de retourner les erreurs dans des tableaux
- Type de retour imprévisible
- Code verbeux et répétitif
- Source de bugs (oubli de vérification)

### 3. Utilisez les exceptions (méthode recommandée)
- Code propre et prévisible
- Gestion d'erreur obligatoire et explicite
- APIs correctes avec codes HTTP appropriés
- Facilite la maintenance et le débogage

### 4. Avantages des exceptions

**Séparation des flux :**
```php
try {
    // Flux normal : code métier clair
    $user = getUserData(1);
    $order = createOrder($user);
    $payment = processPayment($order);
} catch (UserNotFoundException $e) {
    // Flux erreur : gestion centralisée
} catch (PaymentException $e) {
    // Différents types d'erreurs
}
```

**Type prévisible :**
```php
// Avec exceptions, $user est TOUJOURS un tableau d'utilisateur
$user = getUserData(1);
echo $user['name']; // Pas de vérification nécessaire

// Avec tableaux, on ne sait jamais :
$result = getUserData(1);
echo $result['user']['name']; // Peut crasher si erreur !
```

**Gestion obligatoire :**
```php
// Si on oublie le try-catch, l'exception remonte
// et on voit l'erreur immédiatement (pas de bug silencieux)
```

## 📊 Tableau Comparatif

| Critère | Approche 1 (echo + die) | Approche 2 (Tableau) | Approche 3 (Exceptions) |
|---------|-------------------------|----------------------|------------------------|
| HTML/JSON valide | ❌ Cassé | ✅ Valide | ✅ Valide |
| Type prévisible | ❌ N/A | ❌ Mixte | ✅ Prévisible |
| Code propre | ⚠️ Simple mais dangereux | ❌ Verbeux | ✅ Élégant |
| Gestion forcée | ❌ Aucune | ❌ Facultative | ✅ Obligatoire |
| Codes HTTP (API) | ❌ Non | ❌ Toujours 200 | ✅ Appropriés |
| Maintenabilité | ❌ Très mauvaise | ⚠️ Moyenne | ✅ Excellente |

## 🔧 Cas d'Usage Avancés

### Gestion centralisée des exceptions

```php
// Dans votre fichier principal (index.php, bootstrap.php...)
set_exception_handler(function($exception) {
    // Log l'erreur
    error_log($exception->getMessage());

    // Affichage approprié selon le contexte
    if (isApiRequest()) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    } else {
        include 'error-page.php';
    }
});
```

### Hiérarchie d'exceptions

```php
class AppException extends Exception {}
class UserException extends AppException {}
class UserNotFoundException extends UserException {}
class UserNotAuthorizedException extends UserException {}

class DatabaseException extends AppException {}
class ConnectionException extends DatabaseException {}
class QueryException extends DatabaseException {}

// Permet de catcher à différents niveaux
try {
    // ...
} catch (UserNotFoundException $e) {
    // Gestion spécifique
} catch (UserException $e) {
    // Gestion générique utilisateur
} catch (AppException $e) {
    // Gestion générique application
}
```

## 📝 Exercices Suggérés

1. **Convertir du code legacy** : Prenez du code avec echo/die et convertissez-le en exceptions
2. **Créer une hiérarchie** : Créez vos propres classes d'exceptions pour votre domaine métier
3. **Gestionnaire global** : Implémentez un gestionnaire d'exceptions centralisé
4. **API REST** : Créez une API REST complète utilisant les exceptions avec les bons codes HTTP

## 🎓 Ressources Complémentaires

- [Documentation PHP : Exceptions](https://www.php.net/manual/fr/language.exceptions.php)
- [PSR-12 : Extended Coding Style Guide](https://www.php-fig.org/psr/psr-12/)
- [Best Practices for Modern PHP](https://phptherightway.com/)

## 📜 Licence

Ce workshop est fourni à des fins éducatives. Libre à vous de l'utiliser et de le modifier.

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
- Signaler des bugs
- Proposer des améliorations
- Ajouter des exemples
- Traduire le contenu

---

**Happy Coding!** 🚀

*N'oubliez pas : les exceptions sont vos amies, pas vos ennemies !*
