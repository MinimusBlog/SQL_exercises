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
		if(myCodeMirror.getValue()===awnser){
			check_result.innerHTML="ПРАВИЛЬНО";
		}else{
			check_result.innerHTML="неа)";
		}
	}