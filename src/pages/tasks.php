<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../styles/global.css"/>
	<title>SQL Maestro</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,regular,500,600,700,800,900,100italic,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic" rel="stylesheet"/>
	<link rel="stylesheet" href="../styles/sections/components.css"/>
	<link rel="stylesheet" href="../styles/sections/header.css"/>
    <link rel="stylesheet" href="../styles/sections/tasks.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/elegant.min.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/sql/sql.min.js"></script>

	<!-- обращение к БД -->
	<?php
			include '../includes/settings.php';
			session_start();
				$sql = "SELECT * FROM tasks";
				$result = mysqli_query($link, $sql);

				if (!$result) {
					die("Ошибка выполнения запроса: " . mysqli_error($link));
				}

				$taskText =  "";
				$taskHint =  "";
				$taskAwnser =  "";
				if (isset($_COOKIE['level'])) {
					$id = (int)$_COOKIE['level'];
					echo "Текущий уровень: $id<br>";
				} else {
					$id = 1; // Значение по умолчанию
					echo "Кука 'level' не установлена. Используется уровень по умолчанию: $id<br>";
				}
				function loadFromDB($id, &$taskText, &$taskHint, &$taskAwnser, $result) {
					while ($row = mysqli_fetch_assoc($result)) {
						if ($row["taskID"] == $id) {
							$taskText = $row["taskText"];
							$taskHint = $row["taskHint"];
							$taskAwnser = $row["taskAwnser"];
							return; // Завершаем выполнение функции, если нашли задание
						}
					}
					// Если задание не найдено
					echo "Задание с ID $id не найдено.";
				}

				loadFromDB($id, $taskText, $taskHint, $taskAwnser, $result);
				?>
</head>
<body>
	<header class="header">
        <div class="header__wrapper">
            <a href="../index.php"><img src="../images/logo.svg" alt="Логотип"></a>
            <nav>
                <ul class="menu">
                    <li class="menu__item menu__item"><a href="../modules/article.php">Справочник</a></li>
                    <li class="menu__item"><a href="../pages/tests.html">Тесты</a></li>
                    <li class="menu__item menu__item--active"><a href="#">Задачник</a></li>
                    <li class="menu__item"><a href="#">Песочница</a></li>
                </ul>
            </nav>
            <a href="../modules/auth.php" class="header__login" aria-label="Вход в личный кабинет">
                <img src="../images/icons/user.svg" alt="Иконка пользователя">
            </a>
            <button class="header__mobile-menu-button" aria-expanded="false" aria-haspopup="true">
                <img src="../images/icons/burger.svg" alt="Мобильное меню">
            </button>
        </div>
    </header>

			<!-- номер задачи -->
			<div class="level">
				<h1 class="level__number">Номер <?php echo $id+1;?></h1>
			</div>

			<!-- окно с задачей -->
			<div class="task window">
				<p class="task__text"><?php echo $taskText;?></p>
			</div>

			<!-- всплывающая подсказка -->
			<div class="hint">
				<p class="hint__text"><?php echo $taskHint ?></p>
				<div class="under-editor">
					<button class="button button-active" onclick="hint__button__onClick()">показать подсказку</button>
					<button class="button button-active" onclick="menu__levels()">Задания</button>
					<p class="window timer"></p>
					<div class="level-menu window">
						<p style="height:0;padding:0px; margin:14px 4px;">Уровни</p>
						<table style="height:0;padding:0px; margin:0px;">
						<?php
						for ($i = 0; $i < 5; $i++) {
							echo "<tr>";
							for ($j = 0; $j < 5; $j++) {
								$taskID = $i * 5 + $j + 1; // Генерация taskID
								echo "<td><input class='checkbox' type='checkbox' name='$taskID' onclick='updbox(this)'></td>";
							}
							echo "</tr>";
						}
						?>
						</table>
					</div>
				</div>
			<hr class="line" noshade>
			<!-- codemirror, который чистый JS -->
			<textarea class="editor__textarea"></textarea>

			<!-- часть с кнопкой проверить -->
			<div class="check">
				<button class="button button-active" onclick="checkAwnser()">проверить</button>
				<p class="check__result window">Решите задачу, чтобы узнать правильность вашего решения</p>
			</div>

	<script src="../scripts/main.js"></script>
</body>
</html>