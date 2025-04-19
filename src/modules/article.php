<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <title>SQL Справочник</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/page.css">
    <link rel="stylesheet" href="../styles/components.css">
</head>
<body>
    <header class="header">
        <div class="header__wrapper">
            <a href="../index.php"><img class="header__logo" src="../images/logo.svg" alt="Логотип SQL Maestro"></a>
            <nav>
                <ul class="menu">
                    <li class="menu__item menu__item--active"><a href="#">Справочник</a></li>
                    <li class="menu__item"><a href="#">Тесты</a></li>
                    <li class="menu__item"><a href="#">Задачник</a></li>
                    <li class="menu__item"><a href="#">Песочница</a></li>
                </ul>
            </nav>
            <a href="#" class="header__login" aria-label="Вход в личный кабинет">
                <img src="../images/icons/user.svg" alt="Иконка пользователя">
            </a>
            <button class="header__mobile-menu-button" aria-expanded="false" aria-haspopup="true">
                <img src="../images/icons/burger.svg" alt="Мобильное меню">
            </button>
        </div>
    </header>
</body>
</html>

<div class="article_wrapper">

<?php
require_once '../includes/settings.php';

function getArticle($link, $id) {
    $stmt = $link->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Возвращаем ассоциативный массив с данными статьи
    } else {
        $stmt->close();
        return null; // Статья не найдена
    }
}

function getAllArticles($link) {
    $stmt = $link->prepare("SELECT id, title FROM articles ORDER BY id ASC");
    $stmt->execute();
    $result = $stmt->get_result();

    $articles = [];
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row; // Добавляем каждую статью в массив
    }
    return $articles;
}

// Получаем ID статьи из URL
$articleID = isset($_GET['id']) ? (int)$_GET['id'] : 0; // Проверяем, передан ли ID

if ($articleID > 0) {
    $article = getArticle($link, $articleID); // Загружаем статью с указанным ID
    if ($article) {
        echo "<h1 class='article__title'>" . htmlspecialchars($article['title']) . "</h1>";
        echo "<p class='article--description'>" . htmlspecialchars($article['content']) . "</p>";
    } else {
        echo "<p class='article--notfound'>Статья не найдена!</p>";
    }
}

// Переключение между статьями 1 2..
$articles = getAllArticles($link);
echo "<div class='pagination'>";
foreach ($articles as $article) {
    $activeClass = ($article['id'] == $articleID) ? 'active' : '';
    echo "<a href='article.php?id=" . $article['id'] . "' class='page--link $activeClass'>" . $article['id'] . "</a>";
}
echo "</div>";
?>
</div>
<div class="article__btn">
    <a href="../index.php" class="button button--article">Назад</a>
</div>