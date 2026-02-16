<?php
/**
 * APPROCHE 1 : LA MAUVAISE PRATIQUE
 *
 * Cette fonction simule une récupération de données utilisateur.
 * Quand l'utilisateur n'existe pas, elle fait un echo puis die().
 *
 * PROBLÈMES :
 * - Le echo() envoie du texte brut qui casse le format de sortie attendu
 * - Le die() arrête brutalement l'exécution, laissant la page HTML incomplète
 * - Impossible de gérer l'erreur proprement dans le code appelant
 */

function getUserData($userId) {
    // Simulation d'une base de données
    $users = [
        1 => ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
        2 => ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
    ];

    // Si l'utilisateur n'existe pas : MAUVAISE gestion d'erreur
    if (!isset($users[$userId])) {
        echo "Erreur: L'utilisateur avec l'ID $userId n'existe pas !";
        die(); // Arrêt brutal du script
    }

    return $users[$userId];
}
