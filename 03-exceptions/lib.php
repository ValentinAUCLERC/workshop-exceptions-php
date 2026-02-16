<?php
/**
 * APPROCHE 3 : LES EXCEPTIONS (LA BONNE PRATIQUE)
 *
 * Cette fois, on utilise les exceptions pour gérer les erreurs.
 * C'est la méthode recommandée en PHP moderne.
 *
 * AVANTAGES :
 * ✅ Séparation claire entre le flux normal et le flux d'erreur
 * ✅ Type de retour prévisible : soit des données, soit une exception
 * ✅ Impossible d'oublier de gérer l'erreur (sinon l'exception remonte)
 * ✅ Code propre et lisible
 * ✅ Gestion centralisée des erreurs possible
 */

class UserNotFoundException extends Exception {}

function getUserData($userId) {
    // Simulation d'une base de données
    $users = [
        1 => ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
        2 => ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
    ];

    // Si l'utilisateur n'existe pas : on LANCE une exception
    if (!isset($users[$userId])) {
        throw new UserNotFoundException("L'utilisateur avec l'ID $userId n'existe pas");
    }

    // Si on arrive ici, c'est que tout va bien
    // Le retour est TOUJOURS des données d'utilisateur
    return $users[$userId];
}

/**
 * Avantages illustrés :
 *
 * 1. Type de retour prévisible :
 *    $user = getUserData(1); // Toujours un tableau d'utilisateur
 *    // Pas besoin de vérifier isset($user['error'])
 *
 * 2. Gestion explicite des erreurs :
 *    try {
 *        $user = getUserData(999);
 *    } catch (UserNotFoundException $e) {
 *        // Gestion de l'erreur EXPLICITE
 *    }
 *
 * 3. Si on oublie le try-catch, l'exception remonte et on le voit immédiatement
 *    (au lieu d'un bug silencieux)
 */
