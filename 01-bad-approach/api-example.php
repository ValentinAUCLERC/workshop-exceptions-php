<?php
/**
 * EXEMPLE API JSON - APPROCHE 1 : echo + die()
 *
 * Démonstration du problème : le echo() mélange du texte brut dans le JSON
 * Le die() empêche l'envoi du JSON complet
 */

require_once 'lib.php';

// On déclare qu'on va renvoyer du JSON
header('Content-Type: application/json');

// Préparation de la réponse JSON
$response = [
    'status' => 'success',
    'data' => []
];

// Récupération de l'utilisateur 1 (existe)
$user1 = getUserData(1);
$response['data'][] = $user1;

// Récupération de l'utilisateur 999 (n'existe pas)
// ATTENTION : Cette ligne va faire echo + die()
// Le JSON ne sera JAMAIS complété ni renvoyé correctement !
$user2 = getUserData(999);
$response['data'][] = $user2;

// Cette ligne ne sera JAMAIS exécutée à cause du die() plus haut
echo json_encode($response, JSON_PRETTY_PRINT);

/*
 * RÉSULTAT CATASTROPHIQUE :
 *
 * Au lieu d'un JSON valide comme :
 * {
 *     "status": "success",
 *     "data": [...]
 * }
 *
 * Le client reçoit quelque chose comme :
 * Erreur: L'utilisateur avec l'ID 999 n'existe pas !
 *
 * Ce n'est même pas du JSON valide !
 * - Les applications clientes vont crasher en essayant de parser
 * - Impossible de distinguer programmatiquement une erreur d'une réponse valide
 * - Pas de code HTTP approprié (toujours 200 OK)
 */
