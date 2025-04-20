<?php 
session_start();
if (!isset($_SESSION['auth'])) {
    header("Location: /modules/auth.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <?php 
    if (isset($_SESSION['message'])) {
        echo "<p>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>
    <h1>Добро пожаловать на дашборд!</h1>
    <a href="/auth/logout.php">Выйти</a>
</body>
</html>