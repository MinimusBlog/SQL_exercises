<?php
header('Content-Type: application/json');

// Подключаем настройки базы данных
require_once '../includes/settings.php';

$sql = $_POST['sql'] ?? '';

if (empty($sql)) {
    echo json_encode([
        'success' => false,
        'error' => 'SQL-запрос не может быть пустым.'
    ]);
    exit;
}

try {
    // Используем подключение из settings.php
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $start = microtime(true);
    $stmt = $pdo->query($sql);
    $time = round((microtime(true) - $start) * 1000, 2); // в мс

    // Получаем данные, если SELECT
    $result = [];
    if (preg_match('/^\s*SELECT/i', $sql)) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode([
        'success' => true,
        'data' => $result,
        'time' => $time . ' мс'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}