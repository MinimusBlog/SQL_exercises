<!DOCTYPE html><html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/global.css"/>
	<title>SQL Maestro</title>
	
	<!-- импортируем тут всякое... -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet"/>
	<link rel="stylesheet" href="../styles/components.css"/>
	<link rel="stylesheet" href="../styles/header.css"/>
    <link rel="stylesheet" href="../styles/tasks.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/elegant.min.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/sql/sql.min.js"></script>

</head>
<body>
	<header class="header">
        <div class="header__wrapper">
            <a href="../index.php"><img src="../images/logo.svg" alt="Логотип"></a>
            <nav>
                <ul class="menu">
                    <li class="menu__item menu__item"><a href="../index.html">Справочник</a></li>
                    <li class="menu__item"><a href="#">Тесты</a></li>
                    <li class="menu__item menu__item--active"><a href="#">Задачник</a></li>
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
		<div class="execute">
			<button class="button button-active" onclick="executeSQL()">Выполнить SQL</button>
		</div>

			<!-- номер задачи -->
			<div class="level">
				<h1 class="level__number">Здесь номер задачи</h1>
			</div>

			<!-- окно с задачей -->
			<div class="task window">
				<p class="task__text">Это текстовое поле с заданием. <br>да.</p>
			</div>

			<!-- всплывающая подсказка -->
			<div class="hint">
				<p class="hint__text">"Это подсказка... надо написать HI"</p>
				<button class="button button-active" onclick="hint__button__onClick()">показать подсказку</button>
			</div>
			<hr class="line" noshade>
			<!-- codemirror, который чистый JS -->
			<textarea class="editor__textarea">А это поле для написания кода SQL..</textarea>

			<!-- часть с кнопкой проверить -->
			<div class="check">
				<button class="button button-active" onclick="checkAwnser()">проверить</button>
				<p class="check__result window">тут текст меняется на правильно и нет</p>
			</div>
		</div>

	<script type="modules" href="../scripts/main.js"></script>
	
</body>
</html> 