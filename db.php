<?php
// Настройки подключения к базе данных
$host = 'localhost';    // Адрес сервера базы данных
$dbname = 'user_auth'; // Имя базы данных
$user = 'root';     // Имя пользователя
$password = 'Awse1703Kolp'; // Пароль

// Создание подключения с использованием PDO для защиты от SQL-инъекций
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Обработка ошибки подключения
    die("Ошибка подключения к базе данных");
}
