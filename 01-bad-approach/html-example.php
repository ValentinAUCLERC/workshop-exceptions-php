<?php
/**
 * EXEMPLE HTML - APPROCHE 1 : echo + die()
 *
 * Démonstration du problème : le die() casse la structure HTML
 */

require_once 'lib.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exemple HTML - Mauvaise approche</title>
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
    <h1>Profil Utilisateur - Approche 1</h1>

    <div class="card">
        <h2>Utilisateur existant (ID 1)</h2>
        <?php
        $user1 = getUserData(1); // Cet utilisateur existe
        ?>
        <div class="user-info">
            <p><strong>Nom :</strong> <?= htmlspecialchars($user1['name']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user1['email']) ?></p>
        </div>
    </div>

    <div class="card">
        <h2>Utilisateur inexistant (ID 999)</h2>
        <?php
        // ATTENTION : Cette ligne va faire echo + die()
        // Le reste de la page HTML ne sera JAMAIS affiché !
        $user2 = getUserData(999); // Cet utilisateur n'existe pas
        ?>
        <div class="user-info">
            <p><strong>Nom :</strong> <?= htmlspecialchars($user2['name']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($user2['email']) ?></p>
        </div>
    </div>

    <!--
        PROBLÈME : Tout ce qui suit ne sera JAMAIS affiché à cause du die() !
        Les balises HTML ne sont pas fermées, le footer n'apparaît pas.
        Inspectez le code source de la page pour voir le désastre !
    -->

    <footer>
        <p>Ce footer ne sera jamais affiché si getUserData(999) est appelé !</p>
        <p>La structure HTML est brisée 💔</p>
    </footer>
</body>
</html>
