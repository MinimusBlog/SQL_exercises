<?php
header('Content-Type: application/json');

// Подключаем настройки БД
require_once '../includes/settings.php';

// Проверка переменных подключения
if (!isset($servername, $username, $password, $dbname)) {
    echo json_encode([
        'success' => false,
        'error' => 'Настройки подключения к БД не заданы.'
    ]);
    exit;
}

$sql = $_POST['sql'] ?? '';

if (empty(trim($sql))) {
    echo json_encode([
        'success' => false,
        'error' => 'SQL-запрос не может быть пустым.'
    ]);
    exit;
}

// Небезопасные ключевые слова
$forbidden = ['DROP', 'DELETE', 'TRUNCATE', 'ALTER', 'GRANT', 'REVOKE', 'FLUSH', 'SHUTDOWN', '--', '#'];

foreach ($forbidden as $word) {
    if (preg_match('/\b' . preg_quote($word, '/') . '\b/i', $sql)) {
        echo json_encode([
            'success' => false,
            'error' => "Операция \"$word\" запрещена по соображениям безопасности."
        ]);
        exit;
    }
}

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $start = microtime(true);

    if (preg_match('/^\s*(SHOW|DESCRIBE)/i', $sql)) {
        $stmt = $pdo->query($sql);
    } else {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    $time = round((microtime(true) - $start) * 1000, 2); // мс

    if (preg_match('/^\s*SELECT/i', $sql)) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            'success' => true,
            'type' => 'select',
            'data' => $result,
            'time' => $time . ' мс'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'type' => 'other',
            'affected' => $stmt->rowCount(),
            'time' => $time . ' мс'
        ]);
    }

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}