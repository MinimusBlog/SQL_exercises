// реализация окна для кодинга
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
		hint_text.left=0;
		hint_text.animationPlayState="running";
	}
	
	//проверка ответа
	function checkAwnser(){
		if(myCodeMirror.getValue()==="HI"){
			check_result.innerHTML="ПРАВИЛЬНО";
		}else{
			check_result.innerHTML="неа)";
		}
	}

	function executeSQL() {
		const sqlQuery = myCodeMirror.getValue(); // Получаем SQL-запрос из CodeMirror

		fetch('../pages/Timer-SQL.php', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			body: `sql=${encodeURIComponent(sqlQuery)}`
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				document.getElementById('result').textContent = JSON.stringify(data.data, null, 2);
				document.getElementById('time').textContent = `Время выполнения: ${data.time}`;
			} else {
				document.getElementById('result').textContent = `Ошибка: ${data.error}`;
			}
		})
		.catch(error => {
			document.getElementById('result').textContent = `Ошибка запроса: ${error}`;
		});
	}