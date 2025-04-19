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

// Небезопасные ключевые слова
$forbidden = ['DROP', 'DELETE', 'TRUNCATE', 'ALTER', 'GRANT', 'REVOKE', 'FLUSH', 'SHUTDOWN'];

// Проверка наличия опасных слов
foreach ($forbidden as $word) {
    if (preg_match('/\b' . $word . '\b/i', $sql)) {
        echo json_encode([
            'success' => false,
            'error' => "Операция \"$word\" запрещена по соображениям безопасности."
        ]);
        exit;
    }
}

try { // в следуюшей строке меняй dns и тд это просто пример
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $start = microtime(true);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $time = round((microtime(true) - $start) * 1000, 2); // в мс

    if (preg_match('/^\s*SELECT/i', $sql)) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            'success' => true,
            'type' => 'select',
            'data' => $result,
            'time' => $time . ' мс'
        ]);
    } else {
        $affected = $stmt->rowCount();
        echo json_encode([
            'success' => true,
            'type' => 'other',
            'affected' => $affected,
            'time' => $time . ' мс'
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}