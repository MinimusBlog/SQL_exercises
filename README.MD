# SQL_exercises
---
## Инструменты, использованные для создания сайта:
- [CodeMirror](https://codemirror.net/).
- [MAMP](https://www.mamp.info/en/windows/).
- [cdnjs](https://cdnjs.com/).   
- [Ani.js](https://anijs.github.io/)
---

## Команды, которые использовались в проекте:
- инициализация редактора кода:
    ```javascript
    let editor = document.getElementsByClassName("editor__textarea")[0];
    let myCodeMirror = CodeMirror.fromTextArea(editor,{
        lineNumbers: true,
        mode: "sql"
    });
    ```
    где:
    - editor__textarea - текстовое поле html
    - CodeMirror.fromTextArea() - конструктор редактора из текстового поля html
- определение правильного ответа:
    ```javascript
    function checkAwnser(){
		if(myCodeMirror.getValue()==="HI"){
			check_result.innerHTML="ПРАВИЛЬНО";
		}else{
			check_result.innerHTML="неа)";
		}
	}
    ```
    где:
    - myCodeMirror - ранее инициализованный редактор кода
    - getValue() - геттер содержимого, вводимого пользователем