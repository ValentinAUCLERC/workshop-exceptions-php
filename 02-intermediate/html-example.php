<?php
/**
 * EXEMPLE HTML - APPROCHE 2 : erreur dans tableau
 *
 * Démonstration : le code est plus lourd et le risque d'erreur persiste
 */

require_once 'lib.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exemple HTML - Approche intermédiaire</title>
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
        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: white;
            border-radius: 8px;
        }
        .warning {
            background: #fff3e0;
            padding: 15px;
            border-left: 4px solid #ff9800;
            color: #e65100;
            margin-top: 10px;
        }
        .bug-demo {
            background: #fce4ec;
            padding: 15px;
            border-left: 4px solid #e91e63;
            color: #880e4f;
            margin-top: 10px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <h1>Profil Utilisateur - Approche 2</h1>

    <div class="card">
        <h2>Utilisateur existant (ID 1)</h2>
        <?php
        $result1 = getUserData(1);

        // OBLIGATION : vérifier si c'est une erreur ou des données
        if (isset($result1['error'])) {
            echo '<div class="error">' . htmlspecialchars($result1['error']) . '</div>';
        } else {
            // Encore une vérification : est-ce bien dans ['user'] ?
            $user = $result1['user'];
            ?>
            <div class="user-info">
                <p><strong>Nom :</strong> <?= htmlspecialchars($user['name']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="card">
        <h2>Utilisateur inexistant (ID 999)</h2>
        <?php
        $result2 = getUserData(999);

        // Même vérification à répéter PARTOUT
        if (isset($result2['error'])) {
            echo '<div class="error">' . htmlspecialchars($result2['error']) . '</div>';
        } else {
            $user = $result2['user'];
            ?>
            <div class="user-info">
                <p><strong>Nom :</strong> <?= htmlspecialchars($user['name']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="card">
        <h2>⚠️ DANGER : Oubli de vérification (ID 888)</h2>
        <div class="warning">
            <strong>Démonstration du bug classique :</strong><br>
            Si un développeur oublie de vérifier <code>isset($result['error'])</code>,
            il se prend une erreur "undefined index" en pleine face !
        </div>
        <?php
        $result3 = getUserData(888);

        // ❌ MAUVAIS CODE : on oublie de vérifier l'erreur !
        // On accède directement à ['user'] sans vérifier

        // Pour la démo, on capture l'erreur pour l'afficher joliment
        error_reporting(0); // Désactive temporairement les warnings
        $user = @$result3['user']; // @ supprime le warning
        error_reporting(E_ALL); // Réactive

        if ($user === null) {
            ?>
            <div class="bug-demo">
                <strong>💥 ERREUR FATALE (simulée) :</strong><br>
                <code>
                Warning: Undefined array key "user" in html-example.php on line XX<br>
                Fatal error: Trying to access array offset on value of type null
                </code>
            </div>
            <div class="warning" style="margin-top: 15px;">
                <strong>Explication :</strong><br>
                Le développeur a écrit <code>$user = $result3['user'];</code><br>
                Mais $result3 contient <code>['error' => '...']</code> et PAS de clé 'user' !<br>
                Résultat : crash de l'application 💣
            </div>
            <?php
        }
        ?>

        <div style="margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 5px;">
            <strong>Code problématique typique :</strong>
            <pre style="background: #263238; color: #aed581; padding: 15px; border-radius: 5px; overflow-x: auto;">
<code>// ❌ Code dangereux !
$result = getUserData(888);
$userName = $result['user']['name']; // CRASH si erreur !
echo $userName;

// ✅ Code correct (mais verbeux)
$result = getUserData(888);
if (isset($result['error'])) {
    echo "Erreur: " . $result['error'];
} else {
    $userName = $result['user']['name'];
    echo $userName;
}</code></pre>
        </div>
    </div>

    <!--
        AVANTAGES par rapport à l'approche 1 :
        ✅ Le HTML complet est bien affiché (pas de die())
        ✅ L'erreur est affichée proprement dans l'interface
        ✅ Le footer est bien présent

        PROBLÈMES persistants :
        ⚠️ Code verbeux et répétitif (if/else partout)
        ⚠️ Risque d'oublier la vérification isset($result['error'])
        ⚠️ Pas de distinction claire entre les flux "succès" et "erreur"
        ⚠️ Si on ajoute 10 appels à getUserData(), on ajoute 10 if/else
    -->

    <footer>
        <p>Cette fois, le footer s'affiche bien ! ✅</p>
        <p>Mais le code est devenu lourd et répétitif 😕</p>
    </footer>
</body>
</html>
