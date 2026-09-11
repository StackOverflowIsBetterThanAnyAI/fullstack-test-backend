<?php
$dbFile = __DIR__ . '/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbFile", null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT, 
        name TEXT,
        surname TEXT
    )");

    return $pdo;
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "DB-Fehler: " . $e->getMessage()]);
    exit();
}
