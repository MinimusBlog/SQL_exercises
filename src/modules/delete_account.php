<?php
session_start();
include '../includes/settings.php';

// Проверяем авторизован ли пользователь
if (!isset($_SESSION['auth'])) {
    header("Location: /src/modules/auth.php");
    exit();
}

$deleteError = $deleteSuccess = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['id'];
    $password = $_POST['password'];
    // Проверяем существует ли пользователь
    $query = "SELECT * FROM users WHERE id='$id'";
    $res = mysqli_query($link, $query);

    if ($res) {
        $user = mysqli_fetch_assoc($res);

        if ($user && password_verify($password, $user['password'])) {

            // Удаляем пользователя
            $delete_query = "DELETE FROM users WHERE id='$id'";
            if (mysqli_query($link, $delete_query)) {
                session_destroy();
                header("Location: ./modules/auth.php");
                exit();
            } else {
                // Ошибка при удалении аккаунта
                http_response_code(404);
                include '../pages/error404.php';
                exit();
            }
        } else {
            // Неверный пароль
            $deleteError = "Неверный пароль!";
        }
    } else {
        // Ошибка при выполнении запроса
        http_response_code(404);
        include '../pages/error404.php';
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
</head>
<body>
    <h1>Удалить аккаунт</h1>
    <?php if ($deleteError) echo "<p style='color:red;'>$deleteError</p>"; ?>
    <?php if ($deleteSuccess) echo "<p style='color:green;'>$deleteSuccess</p>"; ?>
    <form action="" method="POST">
        <input type="password" name="password" placeholder="Enter your password to confirm">
        <input type="submit" value="Delete Account">
    </form>
    <a href="../modules/auth.php">Назад в ЛК</a>
</body>
</html>