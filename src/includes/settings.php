<?php

$servername = 'localhost'; // БД хост
$username = 'root'; // БД пользователь
$password = ''; // БД пароль
$dbname =  'sql_exercises'; // имя БД

// Создание подключения
$link = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
?>