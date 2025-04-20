<?php  
include '../includes/settings.php';
session_start();

$loginError = $passwordError = $confirmError = $emailError = $generalError = $authError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        // Регистрация
        $login = $_POST['login'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
        $email = $_POST['email'];

        if (empty($login) || empty($password) || empty($confirm) || empty($email)) {
            $generalError = "All fields are required!";
        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
            $loginError = "Login can only contain letters and numbers!";
        } elseif (strlen($login) < 4 || strlen($login) > 10) {
            $loginError = "Login must be between 4 and 10 characters!";
        } elseif (strlen($password) < 6 || strlen($password) > 12) {
            $passwordError = "Password must be between 6 and 12 characters!";
        } elseif ($password != $confirm) {
            $confirmError = "Passwords do not match!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format!";
        } else {
            $check_query = "SELECT * FROM users WHERE login='$login'";
            $result = mysqli_query($link, $check_query);

            if (mysqli_num_rows($result) == 0) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (login, password, email) VALUES ('$login', '$hashedPassword', '$email')";
                if (mysqli_query($link, $query)) {
                    $user_id = mysqli_insert_id($link);
                    $_SESSION['auth'] = true;
                    $_SESSION['login'] = $login;
                    $_SESSION['id'] = $user_id;
                    header("Location: ../modules/lk.php");
                    exit();
                } else {
                    $generalError = "Registration failed. Please try again.";
                }
            } else {
                $loginError = "Login is already taken. Please choose another one.";
            }
        }
    } elseif (isset($_POST['login_submit'])) {
        // Авторизация
        $login = $_POST['login'];
        $password = $_POST['password'];

        if (!empty($login) && !empty($password)) {
            $query = "SELECT * FROM users WHERE login='$login'";
            $res = mysqli_query($link, $query);
            $user = mysqli_fetch_assoc($res);

            if (!empty($user)) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['message'] = "Вы успешно авторизовались!";
                    $_SESSION['auth'] = true;
                    $_SESSION['login'] = $login;
                    $_SESSION['id'] = $user['id'];
                    header("Location: ../modules/lk.php");
                    exit();
                } else {
                    $authError = "Неверный логин или пароль!";
                }
            } else {
                $authError = "Неверный логин или пароль!";
            }
        } else {
            $authError = "All fields are required!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
</head>
<body>
    <h2>Register</h2>
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
        <input type="submit" name="register" value="Register">
    </form>

    <h2>Login</h2>
    <form action="" method="POST">
        <input name="login" placeholder="Login">
        <input name="password" type="password" placeholder="Password">
        <input type="submit" name="login_submit" value="Login">
        <?php if ($authError) echo "<p style='color:red;'>$authError</p>"; ?>
    </form>
</body>
</html>