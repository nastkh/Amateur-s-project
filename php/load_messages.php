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

$chatId = $_GET['id'];

$stmt = $pdo->prepare('SELECT username, message, timestamp FROM messages WHERE chat_id = ? ORDER BY timestamp ASC');
$stmt->execute([$chatId]);
$messages = $stmt->fetchAll();

echo json_encode($messages);
?>
