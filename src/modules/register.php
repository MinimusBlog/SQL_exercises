<?php  
include '../includes/settings.php';
session_start();

$loginError = $passwordError = $confirmError = $emailError = $generalError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $email = $_POST['email'];

    if (empty($login) || empty($password) || empty($confirm) || empty($email)) {
        $generalError = "Все поля обязательны для заполнения!";
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
        $loginError = "Логин может содержать только буквы и цифры!";
    } elseif (strlen($login) < 4 || strlen($login) > 10) {
        $loginError = "Логин может быть от 4 до 10 символов!";
    } elseif (strlen($password) < 6 || strlen($password) > 12) {
        $passwordError = "Пароль может быть от 6 до 12 символов!";
    } elseif ($password != $confirm) {
        $confirmError = "Пароли не совпадают!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Неверный формат почты!";
    } else {
        $check_query = "SELECT * FROM users WHERE login='$login'";
        $result = mysqli_query($link, $check_query);

        if (mysqli_num_rows($result) == 0) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (login, password, email) VALUES ('$login', '$hashedPassword', '$email')";
            if (mysqli_query($link, $query)) {
                $_SESSION['auth'] = true;
                $_SESSION['login'] = $login;
                header("Location: /dashboard.php");
                exit();
            } else {
                $generalError = "Не удалось зарегистрировать. Пожалуйста, попробуйте ещё раз.";
            }
        } else {
            $loginError = "Логин уже занят. Пожалуйста, выберите другой.";
        }
    }
}
?>

<form action="" method="POST">
    <?php if ($generalError) echo "<p style='color:red;'>$generalError</p>"; ?>
    <input name="login" placeholder="Login" value="<?php echo htmlspecialchars($login ?? ''); ?>">
    <?php if ($loginError) echo "<p style='color:red;'>$loginError</p>"; ?>
    <input type="password" name="password" placeholder="Password">
    <?php if ($passwordError) echo "<p style='color:red;'>$passwordError</p>"; ?>
    <input type="password" name="confirm" placeholder="Confirm Password">
    <?php if ($confirmError) echo "<p style='color:red;'>$confirmError</p>"; ?>
    <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
    <?php if ($emailError) echo "<p style='color:red;'>$emailError</p>"; ?>
    <input type="submit" value="Register">
</form>