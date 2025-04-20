//переменные таймера
let menu__isShown=false;
	let isRunning=true;
	let dtime=0;
	let timer ="";
	
	//инициализация редактора
	let editor = document.getElementsByClassName("editor__textarea")[0];
	let myCodeMirror = CodeMirror.fromTextArea(editor,{
		lineNumbers: true,
		mode: "sql"
		});
	let hint_text = document.getElementsByClassName("hint__text")[0].style;
	let check_result = document.getElementsByClassName("check__result")[0];
	let level_menu = document.getElementsByClassName("level-menu")[0];
	let checkboxes =document.getElementsByClassName("checkbox");
	
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
			isRunning=false;
		}else{
			check_result.innerHTML="ответ неверный. подумайте ещё....";
			
		}
	}
	function menu__levels(){
		menu__isShown=!menu__isShown;
		if(menu__isShown){
			level_menu.style.display="grid";
		}else{
			level_menu.style.display="none";
		}
	}

	//таймер
	function addZero(i){if(i<10){i="0"+i}return i;}
	setInterval(Cycle, 10);
	function Cycle(){

		for (const element of checkboxes) {
			updbox(element);
}
		

		if(isRunning){dtime+=1;}
		timer=addZero(Math.floor(dtime/6000)).toString()+":";
		timer+=addZero(Math.floor((dtime/100)%60).toString())+":";
		timer+=addZero((dtime%100).toString());
		document.getElementsByClassName("timer")[0].innerHTML = timer;
	}
	function updbox(box){
		if(box.checked){
			box.checked=false;
			document.cookie = "level="+box.name;
			window.location.reload();
		}else{
		}

	}

	sal(); //инициализация анимаций