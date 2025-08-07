<?php
header('Content-Type: application/json');

// Récupération du endpoint via PATH_INFO
$endpoint = null;
if (isset($_SERVER['PATH_INFO'])) {
    $endpoint = trim($_SERVER['PATH_INFO'], '/');
}

// Lire les paramètres
$a = isset($_GET['a']) ? (int) $_GET['a'] : null;
$b = isset($_GET['b']) ? (int) $_GET['b'] : null;

// Vérifier que endpoint, a et b existent
if ($endpoint === null || $endpoint === '') {
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint non trouvé.']);
    exit;
}

if ($a === null || $b === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Les paramètres "a" et "b" sont requis.']);
    exit;
}

// Traitement de l'opération
switch ($endpoint) {
    case 'addition':
        echo json_encode(['operation' => 'addition', 'result' => $a + $b]);
        break;

    case 'soustraction':
        echo json_encode(['operation' => 'soustraction', 'result' => $a - $b]);
        break;

    case 'multiplication':
        echo json_encode(['operation' => 'multiplication', 'result' => $a * $b]);
        break;

    case 'division':
        if ($b === 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Division par zéro impossible.']);
        } else {
            echo json_encode(['operation' => 'division', 'result' => $a / $b]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint non trouvé.']);
        break;
}
