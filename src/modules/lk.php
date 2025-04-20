<?php 
session_start();
include '../includes/settings.php';

if (!isset($_SESSION['auth'])) {
    header("Location: /modules/auth.php");
    exit();
}

$oldPasswordError = $newPasswordError = $confirmPasswordError = $generalError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $newPasswordConfirm = $_POST['new_password_confirm'];

    if (empty($oldPassword) || empty($newPassword) || empty($newPasswordConfirm)) {
        $generalError = "All fields are required!";
    } elseif ($newPassword !== $newPasswordConfirm) {
        $confirmPasswordError = "Новый пароль не совпадает!";
    } elseif (strlen($newPassword) < 6 || strlen($newPassword) > 12) {
        $newPasswordError = "Пароль должен содержать от 6 до 12 символов!";
    } else {
        $login = $_SESSION['login'];
        $query = "SELECT * FROM users WHERE login='$login'";
        $res = mysqli_query($link, $query);
        $user = mysqli_fetch_assoc($res);
        $hash = $user['password'];

        if (password_verify($oldPassword, $hash)) {
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password='$newHash' WHERE login='$login'";
            if (mysqli_query($link, $update_query)) {
                echo "Пароль успешно изменён!";
            } else {
                $generalError = "Не удалось изменить пароль. Пожалуйста, попробуйте ещё раз.";
            }
        } else {
            $oldPasswordError = "Неверный старый пароль!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
</head>
<body>
    <header>
        <?php if (!empty($_SESSION['auth'])): ?>
            <p>Приветствую, <?php echo htmlspecialchars($_SESSION['login']); ?>!</p>
        <?php else: ?>
            <a href="/auth/auth.php">Логин</a>
        <?php endif; ?>
    </header>
    <form action="" method="POST">
        <?php if ($generalError) echo "<p style='color:red;'>$generalError</p>"; ?>
        <input type="password" name="old_password" placeholder="Old Password">
        <?php if ($oldPasswordError) echo "<p style='color:red;'>$oldPasswordError</p>"; ?>
        <input type="password" name="new_password" placeholder="New Password">
        <?php if ($newPasswordError) echo "<p style='color:red;'>$newPasswordError</p>"; ?>
        <input type="password" name="new_password_confirm" placeholder="Confirm New Password">
        <?php if ($confirmPasswordError) echo "<p style='color:red;'>$confirmPasswordError</p>"; ?>
        <input type="submit" name="submit" value="Change Password">
    </form>
    <a href="../auth/delete_account.php">Удалить аккаунт</a>
    <a href="../auth/logout.php">Выйти</a>
</body>
</html>