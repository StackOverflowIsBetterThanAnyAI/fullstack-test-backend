<?php
$pdo = require __DIR__ . '/../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Nur POST erlaubt"]);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$name = trim($input['name'] ?? '');
$surname = trim($input['surname'] ?? '');

if (empty($name) || empty($surname)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Name oder Surname fehlen"]);
    exit();
}

$stmt = $pdo->prepare("INSERT INTO users (name, surname) VALUES (:name, :surname)");
$stmt->execute(['name' => $name, 'surname' => $surname]);

http_response_code(201);
echo json_encode([
    "status" => "success",
    "message" => "User erstellt",
    "data" => ["id" => $pdo->lastInsertId(), "name" => $name, "surname" => $surname]
]);
