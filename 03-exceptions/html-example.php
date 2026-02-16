<?php
/**
 * EXEMPLE HTML - APPROCHE 3 : exceptions avec try-catch
 *
 * Démonstration : code propre, lisible, et robuste
 */

require_once 'lib.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exemple HTML - Exceptions (bonne pratique)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .user-info {
            background: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196F3;
        }
        .error {
            background: #ffebee;
            padding: 15px;
            border-left: 4px solid #f44336;
            color: #c62828;
        }
        .success {
            background: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #4caf50;
            color: #2e7d32;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: white;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h1>Profil Utilisateur - Approche 3 (Exceptions)</h1>

    <div class="card">
        <h2>Utilisateur existant (ID 1)</h2>
        <?php
        try {
            // Appel simple : on sait que si ça réussit, on a des données valides
            $user = getUserData(1);
            ?>
            <div class="user-info">
                <p><strong>Nom :</strong> <?= htmlspecialchars($user['name']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div class="success">✅ Utilisateur chargé avec succès</div>
            <?php
        } catch (UserNotFoundException $e) {
            // Gestion de l'erreur propre et centralisée
            echo '<div class="error">❌ ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
    </div>

    <div class="card">
        <h2>Utilisateur inexistant (ID 999)</h2>
        <?php
        try {
            $user = getUserData(999);
            // Si on arrive ici, l'utilisateur existe
            ?>
            <div class="user-info">
                <p><strong>Nom :</strong> <?= htmlspecialchars($user['name']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div class="success">✅ Utilisateur chargé avec succès</div>
            <?php
        } catch (UserNotFoundException $e) {
            // L'exception est capturée ici, proprement
            echo '<div class="error">❌ ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
    </div>

    <!--
        AVANTAGES de cette approche :

        ✅ Séparation claire : le code "normal" dans try, le code "erreur" dans catch
        ✅ Pas de if/else répétitifs
        ✅ Le type de $user est prévisible : c'est toujours un tableau d'utilisateur
        ✅ Impossible d'oublier la gestion d'erreur (sinon exception non catchée)
        ✅ HTML toujours complet et valide
        ✅ Code lisible et maintenable
        ✅ Possibilité de différencier les types d'erreurs (UserNotFoundException, DatabaseException, etc.)

        UTILISATION AVANCÉE :
        On peut même avoir un gestionnaire global d'exceptions pour toute l'application
    -->

    <footer>
        <p>Le footer s'affiche toujours ✅</p>
        <p>Code propre, robuste et maintenable 🎯</p>
    </footer>
</body>
</html>
