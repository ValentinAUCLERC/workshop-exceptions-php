<?php
/**
 * EXEMPLE API JSON - APPROCHE 3 : exceptions avec try-catch
 *
 * Démonstration : gestion d'erreur professionnelle pour une API
 */

require_once 'lib.php';

// Header JSON par défaut
header('Content-Type: application/json');

try {
    // Logique métier principale
    $users = [];

    // Récupération utilisateur 1
    $users[] = getUserData(1);

    // Récupération utilisateur 999 (va lever une exception)
    $users[] = getUserData(999);

    // Si on arrive ici, tout s'est bien passé
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'data' => $users
    ], JSON_PRETTY_PRINT);

} catch (UserNotFoundException $e) {
    // Gestion spécifique : utilisateur non trouvé
    http_response_code(404); // Code HTTP approprié
    echo json_encode([
        'status' => 'error',
        'error' => [
            'type' => 'UserNotFound',
            'message' => $e->getMessage()
        ]
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // Gestion générique pour toute autre erreur
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'error' => [
            'type' => 'InternalError',
            'message' => 'Une erreur inattendue s\'est produite'
        ]
    ], JSON_PRETTY_PRINT);

    // En production, on loggerait l'erreur ici
    error_log($e->getMessage());
}

/*
 * AVANTAGES de cette approche :
 *
 * ✅ JSON TOUJOURS valide
 * ✅ Code HTTP approprié (404 pour not found, 500 pour erreur serveur)
 * ✅ Structure de réponse cohérente (status + data OU status + error)
 * ✅ Distinction entre types d'erreurs (UserNotFoundException vs Exception)
 * ✅ Code propre : la logique métier dans le try, la gestion d'erreur dans le catch
 * ✅ Facile d'ajouter des logs, du monitoring, etc.
 * ✅ Le client API peut parser le JSON et gérer les erreurs proprement
 *
 * STRUCTURE DE RÉPONSE :
 *
 * Succès (200) :
 * {
 *     "status": "success",
 *     "data": [...]
 * }
 *
 * Erreur (404, 500, etc.) :
 * {
 *     "status": "error",
 *     "error": {
 *         "type": "UserNotFound",
 *         "message": "..."
 *     }
 * }
 *
 * COMPARAISON avec l'approche 2 :
 * - Approche 2 : if/else répétitifs, pas de code HTTP, structure incohérente
 * - Approche 3 : clean, cohérent, professionnel
 */
