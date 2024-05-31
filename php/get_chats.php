<?php
header('Content-Type: application/json');

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'form';

$con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if ($con->connect_error) {
    error_log('Помилка підключення до бази даних: ' . $con->connect_error);
    echo json_encode(['error' => 'Помилка підключення до бази даних']);
    exit();
}

$sql = "SELECT id, title, description, image_url FROM chats";
$result = $con->query($sql);

$chats = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chats[] = $row;
    }
} else {
    error_log('No chats found');
}

echo json_encode($chats);

$con->close();
?>