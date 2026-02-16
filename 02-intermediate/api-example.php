<?php
/**
 * EXEMPLE API JSON - APPROCHE 2 : erreur dans tableau
 *
 * Démonstration : meilleur que l'approche 1, mais toujours problématique
 */

require_once 'lib.php';

header('Content-Type: application/json');

$response = [
    'status' => 'success',
    'data' => [],
    'errors' => []
];

// Récupération de l'utilisateur 1 (existe)
$result1 = getUserData(1);
if (isset($result1['error'])) {
    // Gestion de l'erreur
    $response['errors'][] = $result1['error'];
} else {
    // Ajout des données
    $response['data'][] = $result1['user'];
}

// Récupération de l'utilisateur 999 (n'existe pas)
$result2 = getUserData(999);
if (isset($result2['error'])) {
    // On collecte l'erreur
    $response['errors'][] = $result2['error'];
    // Faut-il changer le status en "error" ? "partial_success" ?
    // Pas de convention claire !
} else {
    $response['data'][] = $result2['user'];
}

// Au moins, cette fois on peut envoyer un JSON complet
echo json_encode($response, JSON_PRETTY_PRINT);

/*
 * AVANTAGES par rapport à l'approche 1 :
 * ✅ JSON valide toujours renvoyé
 * ✅ Pas de die() qui coupe l'exécution
 * ✅ Possibilité de collecter plusieurs erreurs
 *
 * PROBLÈMES persistants :
 * ⚠️ Code verbeux : if/else pour chaque appel
 * ⚠️ Pas de code HTTP approprié (toujours 200 OK)
 * ⚠️ Incohérence : status="success" même avec des erreurs ?
 * ⚠️ Le client doit vérifier errors[] ET data[] pour comprendre ce qui s'est passé
 * ⚠️ Risque d'oublier la vérification isset($result['error']) -> bug silencieux
 *
 * EXEMPLE de bug subtil :
 * $user = getUserData(999)['user']; // Fatal error: undefined index 'user'
 * On a oublié de vérifier l'erreur !
 */
