<?php
header('Content-Type: application/json');

$sql = $_POST['sql'] ?? '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=your_db", "your_user", "your_pass");
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