<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'form';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Помилка підключення до бази даних: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) {
    exit('Порожнє поле(я)');
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if (empty($username) || empty($password)) {
    exit('Порожні значення');
}

if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            header('Location: ../html/mainpage.html'); // Перенаправлення на головну сторінку
            exit();
        } else {
            echo 'Невірний пароль. Спробуйте знову.';
        }
    } else {
        echo 'Користувача з таким іменем не знайдено.';
    }
    $stmt->close();
} else {
    echo 'Виникла помилка під час перевірки імені користувача';
}

$con->close();
?>
