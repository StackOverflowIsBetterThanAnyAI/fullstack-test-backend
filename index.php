<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

$pdo = require __DIR__ . '/db.php';

$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

if (preg_match('#^/delete/(\d+)$#', $path, $matches)) {
    $id = $matches[1];
    require __DIR__ . '/routes/deleteUser.php';
    exit();
}

switch ($path) {
    case '/':
    case '/index.php':
        echo json_encode(["status" => "success", "message" => "API läuft!"]);
        break;

    case '/users':
        require __DIR__ . '/routes/getUsers.php';
        break;

    case '/add':
        require __DIR__ . '/routes/addUser.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Route nicht gefunden"]);
        break;
}
