<?php
header('Content-Type: application/json');
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Додати нове повідомлення
    $data = json_decode(file_get_contents('php://input'), true);
    $text = htmlspecialchars($data['text']);

    $stmt = $pdo->prepare("INSERT INTO messages (text) VALUES (:text)");
    $stmt->execute(['text' => $text]);
    echo json_encode(['status' => 'success', 'message' => 'Повідомлення додано!']);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Отримати всі повідомлення
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($messages);
    exit;
}

http_response_code(405); // Метод не підтримується
echo json_encode(['status' => 'error', 'message' => 'Метод не підтримується!']);