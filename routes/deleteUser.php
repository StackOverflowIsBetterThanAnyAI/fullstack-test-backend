<?php

/** @var int $id */
$pdo = require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Nur DELETE-Anfragen erlaubt"]);
    exit();
}

try {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount()) {
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "message" => "User mit ID $id erfolgreich gelöscht."
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            "status" => "error",
            "message" => "User mit ID $id nicht gefunden."
        ]);
    }
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Datenbankfehler beim Löschen: " . $e->getMessage()
    ]);
}
