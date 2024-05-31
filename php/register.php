<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'form';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Помилка підключення до бази даних: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['confirm_password'])) {
    exit('Порожнє поле(я)');
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);
$email = trim($_POST['email']);
$confirm_password = trim($_POST['confirm_password']);

if (empty($username) || empty($password) || empty($email)) {
    exit('Порожні значення');
}

if ($password !== $confirm_password) {
    exit('Паролі не співпадають');
}

if ($stmt = $con->prepare('SELECT id FROM users WHERE username = ?')) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'Ім\'я користувача вже існує. Спробуйте інше';
    } else {
        if ($stmt = $con->prepare('INSERT INTO users (username, password, email) VALUES (?, ?, ?)')) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $username, $hashed_password, $email);
            $stmt->execute();
            echo 'Реєстрація успішна';
            header('Location: ../html/mainpage.html'); // Перенаправлення на головну сторінку
            exit();
        } else {
            echo 'Виникла помилка під час збереження даних';
        }
    }
    $stmt->close();
} else {
    echo 'Виникла помилка під час перевірки імені користувача';
}

$con->close();
?>
