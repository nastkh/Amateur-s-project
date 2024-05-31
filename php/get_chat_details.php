<?php
$servername = "localhost";
$username = "root"; // Замініть на ваше ім'я користувача БД
$password = ""; // Замініть на ваш пароль БД
$dbname = "form"; // Ваша існуюча база даних

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$chatId = $_GET['id'];

$sql = "SELECT * FROM chats WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chatId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $chat = $result->fetch_assoc();
    echo json_encode($chat);
} else {
    echo json_encode(["error" => "Chat not found"]);
}

$stmt->close();
$conn->close();
?>
