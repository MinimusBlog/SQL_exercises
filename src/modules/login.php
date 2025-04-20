<?php 
session_start();
include '../includes/settings.php';

if (!empty($_POST['password']) and !empty($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login='$login'";
    $res = mysqli_query($link, $query);
    $user = mysqli_fetch_assoc($res);

    if (!empty($user)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['message'] = "Вы успешно авторизовались!";
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $login;
            header("Location: ./lk.php");
            exit();
        } else {
            $error_message = "Неверный логин или пароль!";
        }
    } else {
        $error_message = "Неверный логин или пароль!";
    }
}
?>

<?php if (empty($_SESSION['auth'])): ?>
    <form action="/auth/login.php" method="POST">
        <input name="login">
        <input name="password" type="password">
        <input type="submit">
    </form>
    <?php if (!empty($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>
<?php endif; ?>