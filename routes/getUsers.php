<?php
$pdo = require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Nur GET-Anfragen erlaubt"]);
    exit();
}

try {
    $stmt = $pdo->query("SELECT id, name, surname FROM users");
    $users = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "data" => $users
    ]);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Fehler beim Abrufen der Daten: " . $e->getMessage()
    ]);
}
