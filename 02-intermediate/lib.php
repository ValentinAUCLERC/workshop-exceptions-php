<?php
/**
 * APPROCHE 2 : L'APPROCHE INTERMÉDIAIRE
 *
 * Cette fois, on retourne l'erreur dans un tableau au lieu de die().
 * C'est mieux que l'approche 1, mais ça reste problématique.
 *
 * PROBLÈMES :
 * - Le type de retour est imprévisible : parfois des données, parfois une erreur
 * - Le code appelant DOIT vérifier si c'est une erreur à chaque fois
 * - Risque d'oublier la vérification -> bugs subtils
 * - Pas de distinction claire entre "succès" et "échec"
 */

function getUserData($userId) {
    // Simulation d'une base de données
    $users = [
        1 => ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
        2 => ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
    ];

    // Si l'utilisateur n'existe pas : on retourne l'erreur dans un tableau
    if (!isset($users[$userId])) {
        return ['error' => "L'utilisateur avec l'ID $userId n'existe pas"];
    }

    return ['user' => $users[$userId]];
}

/**
 * Problème d'imprévisibilité illustré :
 *
 * Le développeur qui utilise cette fonction doit TOUJOURS vérifier :
 * $result = getUserData(1);
 * if (isset($result['error'])) {
 *     // C'est une erreur
 * } else {
 *     // Ce sont des données... mais sont-elles dans $result['user'] ?
 * }
 *
 * Et si on oublie cette vérification ?
 * $data = $result['user']; // Fatal error si c'est une erreur !
 */
