<?php
$host = 'localhost'; // Змініть на ваш хост
$db = 'form'; // Змініть на вашу базу даних
$user = 'root'; // Змініть на вашого користувача
$pass = ''; // Змініть на ваш пароль

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$data = json_decode(file_get_contents('php://input'), true);

$chatId = $data['chatId'];
$username = $data['username'];
$message = $data['message'];

$stmt = $pdo->prepare('INSERT INTO messages (chat_id, username, message) VALUES (?, ?, ?)');
$success = $stmt->execute([$chatId, $username, $message]);

echo json_encode(['success' => $success]);
?>
