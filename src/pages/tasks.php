<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- настройки сайта (?) -->
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

	<!-- обращение к БД -->
	<?php
				include "../includes/settings.php";
				$sql = "SELECT * FROM tasks";
				$result = mysqli_query($link,$sql);

				$id = 0; // это ID, по которому берётся задание
				$taskText =  "";
				$taskHint =  "";
				$taskAwnser =  "";
				while($row = mysqli_fetch_assoc($result)){
					if ($row["taskID"]==$id){
					$taskText = $row["taskText"];
					$taskHint = $row["taskHint"];
					$taskAwnser = $row["taskAwnser"];
					}
				}
				?>


</head>
<body>
	
	<!-- структура БЭМ (типо) -->
	
	<!-- заголовок  -->
	<header class="header">
        <div class="header__wrapper">
            <a href=""><img src="" alt=""></a>
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
				<button class="button button-active" onclick="hint__button__onClick()">показать подсказку</button>
			</div>
			<hr class="line" noshade>
			<!-- codemirror, который чистый JS -->
			<textarea class="editor__textarea">А это поле для написания кода SQL.</textarea>

			<!-- часть с кнопкой проверить -->
			<div class="check">
				<button class="button button-active" onclick="checkAwnser()">проверить</button>
				<p class="check__result window">тут текст меняется на правильно и нет</p>
			</div>

	<script type="text/javascript">
			let editor = document.getElementsByClassName("editor__textarea")[0];
	let myCodeMirror = CodeMirror.fromTextArea(editor,{
		lineNumbers: true,
		mode: "sql"
		});
	let hint_text = document.getElementsByClassName("hint__text")[0].style;
	let check_result = document.getElementsByClassName("check__result")[0];
	
	// это анимация окна подсказки.
	function hint__button__onClick(){
		//text.visibility="visible";
		hint_text.left="14px";
		hint_text.animationPlayState="running";
	}
	
	//проверка ответа
	function checkAwnser(){
		if(myCodeMirror.getValue()==="<?php echo $taskAwnser;?>"){
			check_result.innerHTML="правильно";
		}else{
			check_result.innerHTML="ответ неверный. подумайте ещё....";
		}
	}
	</script>
</body>
</html> 