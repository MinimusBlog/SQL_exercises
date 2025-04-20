<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/global.css">
    <title>SQL Maestro</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet" />
    <link rel="stylesheet" href="./styles/anicollection.css">
    <link rel="stylesheet" href="./styles/sections/header.css">
    <link rel="stylesheet" href="./styles/sections/page.css">
    <link rel="stylesheet" href="./styles/sections/components.css">
</head>
<body>
    <header class="header">
        <div class="header__wrapper">
            <a href="#" data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                <img class="header__logo" src="./images/logo.svg" alt="Логотип SQL Maestro">
            </a>
            <nav>
                <ul class="menu">
                    <li class="menu__item menu__item--active" data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                        <a href="../src/modules/article.php">Справочник</a>
                    </li>
                    <li class="menu__item" data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                        <a href="../src/pages/tests.html">Тесты</a>
                    </li>
                    <li class="menu__item" data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                        <a href="../src/pages/tasks.php">Задачник</a>
                    </li>
                    <li class="menu__item" data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                        <a href="#">Песочница</a>
                    </li>
                </ul>
            </nav>
            <a href="./modules/auth.php" class="header__login" aria-label="Вход в личный кабинет" 
            data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                <img src="./images/icons/user.svg" alt="Иконка пользователя">
            </a>
            <button class="header__mobile-menu-button" aria-expanded="false" aria-haspopup="true"
            data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                <img src="./images/icons/burger.svg" alt="Мобильное меню">
            </button>
        </div>
    </header>
    <section class="section">
        <div class="hero">
            <div class="hero__left">
            <h1 class="hero__h1">Интерактивный онлайн <br>
            SQL-тренажер</h1>
            <p>Погружайся в практическое изучение SQL <br>
                Осваивай новые возможности языка через <br>
                увлекательные задания и проверяй свои <br>
                знания с помощью комплексных тестов. <br>
                А встроенный справочник всегда прийдет <br>
                к вам на помощь.</p>
                <div class="hero__cta" data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                    <button class="button button-active">Задачник</button>
                </div>
            </div>
            <img class="hero__right" src="./images/sql_ide.svg" alt="SQL IDE">
        </div>
    </section>
    <section class="section">
        <div class="manual">
            <div class="manual__left">
                <h1 class="hero__h1">Справочник SQL</h1>
                <button class="btn button-category" 
                data-anijs="if: click, do: pulse animated, to: $children .content-wrapper">
                Основное</button>
                <p class="manual__p">Основные запросы</p>
                <div class="chip--wrapper chip--wrapper--stroke">
                    <button class="chip chip-active" 
                    onclick="window.location.href='./modules/article.php?id=1'" 
                    data-anijs="if: mouseover, do: pulse animated, to: $children .content-wrapper">
                    SELECT <br>
                    Получение записей</button>
                    <button class="chip"
                    onclick="window.location.href='./modules/article.php?id=2'" 
                    data-anijs="if: mouseover, do: pulse animated, to: $children .content-wrapper">
                    INSERT <br>
                    Вставка записей</button>
                    <button class="chip"
                    onclick="window.location.href='./modules/article.php?id=3'"
                    data-anijs="if: mouseover, do: pulse animated, to: $children .content-wrapper">
                    UPDATE <br>
                    Изменение записей</button>
                    <div class="chip-str">
                        <button class="chip"
                        onclick="window.location.href='./modules/article.php?id=4'"
                        data-anijs="if: mouseover, do: pulse animated, to: $children .content-wrapper">
                        DELETE <br>
                        Удаление записей</button>
                        <button class="chip"
                        onclick="window.location.href='./modules/article.php?id=5'"
                        data-anijs="if: mouseover, do: pulse animated, to: $children .content-wrapper">
                        COUNT <br>
                        Подсчет записей</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="./scripts/anijs-min.js"></script>
    <script src="./scripts/main.js"></script>
</body>
</html>
