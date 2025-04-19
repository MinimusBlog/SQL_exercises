// Данные тестов
const testData = {
    basic: [
        {
            type: "theory",
            question: "Как выбрать все столбцы из таблицы 'users'?",
            answers: [
                "SELECT * FROM users;",
                "SELECT all FROM users;",
                "SELECT FROM users;"
            ],
            correct: 0,
            hint: "Используйте символ * для выбора всех столбцов"
        },
        {
            type: "practice",
            question: "Напишите запрос для выбора всех пользователей старше 30 лет",
            answer: "SELECT * FROM users WHERE age > 30;",
            hint: "Используйте WHERE для фильтрации"
        }
    ],
    join: [
        // Аналогичные вопросы по JOIN
    ],
    subqueries: [
        // Аналогичные вопросы по подзапросам
    ]
};

// Инициализация CodeMirror
const editor = CodeMirror.fromTextArea(document.getElementById('sqlEditor'), {
    mode: 'sql',
    theme: 'elegant',
    lineNumbers: true,
    indentUnit: 4
});

// Текущее состояние теста
let currentTest = [];
let currentQuestionIndex = 0;
let score = 0;

// Загрузка теста
function loadTest(category) {
    currentTest = testData[category];
    currentQuestionIndex = 0;
    score = 0;
    document.getElementById('testCategory').textContent = getCategoryName(category);
    document.getElementById('totalQuestions').textContent = currentTest.length;
    showQuestion();
    document.getElementById('resultsBlock').style.display = 'none';
    document.getElementById('testBlock').style.display = 'block';
}

// Показать текущий вопрос
function showQuestion() {
    const question = currentTest[currentQuestionIndex];
    document.getElementById('questionText').textContent = question.question;
    document.getElementById('currentQuestion').textContent = currentQuestionIndex + 1;
    
    if (question.type === "theory") {
        document.getElementById('answersBlock').style.display = 'block';
        document.getElementById('sqlEditorBlock').style.display = 'none';
        
        const answersContainer = document.getElementById('answersBlock');
        answersContainer.innerHTML = '';
        
        question.answers.forEach((answer, index) => {
            const label = document.createElement('label');
            label.className = 'answer-option';
            label.innerHTML = `
                <input type="radio" name="answer" value="${index}">
                <span>${answer}</span>
            `;
            answersContainer.appendChild(label);
        });
    } else {
        document.getElementById('answersBlock').style.display = 'none';
        document.getElementById('sqlEditorBlock').style.display = 'block';
        editor.setValue('');
        document.getElementById('hintText').style.display = 'none';
    }
    
    document.getElementById('nextButton').disabled = true;
    document.getElementById('testResult').textContent = '';
}

// Проверить ответ
function checkAnswer() {
    const question = currentTest[currentQuestionIndex];
    let isCorrect = false;
    
    if (question.type === "theory") {
        const selected = document.querySelector('input[name="answer"]:checked');
        if (selected && parseInt(selected.value) === question.correct) {
            isCorrect = true;
        }
    } else {
        // Простая проверка - в реальном проекте нужно более сложное сравнение
        const userAnswer = editor.getValue().trim().toLowerCase();
        const correctAnswer = question.answer.trim().toLowerCase();
        isCorrect = userAnswer === correctAnswer;
    }
    
    const resultElement = document.getElementById('testResult');
    if (isCorrect) {
        resultElement.textContent = "Правильно!";
        resultElement.style.color = "green";
        score++;
    } else {
        resultElement.textContent = "Неправильно. Попробуйте еще раз.";
        resultElement.style.color = "red";
    }
    
    document.getElementById('nextButton').disabled = false;
}

// Показать подсказку
function showHint() {
    const hintText = document.getElementById('hintText');
    hintText.style.display = hintText.style.display === 'none' ? 'block' : 'none';
    if (hintText.style.display === 'block') {
        hintText.textContent = currentTest[currentQuestionIndex].hint;
    }
}

// Следующий вопрос
function nextQuestion() {
    currentQuestionIndex++;
    if (currentQuestionIndex < currentTest.length) {
        showQuestion();
    } else {
        showResults();
    }
}

// Показать результаты
function showResults() {
    document.getElementById('testBlock').style.display = 'none';
    document.getElementById('resultsBlock').style.display = 'block';
    document.getElementById('scoreValue').textContent = score;
    document.getElementById('maxScore').textContent = currentTest.length;
    
    const wrongAnswersContainer = document.getElementById('wrongAnswers');
    wrongAnswersContainer.innerHTML = '';
    
    // Здесь можно добавить анализ ошибок
}

// Начать тест заново
function restartTest() {
    loadTest(document.getElementById('testCategory').textContent.toLowerCase());
}

// Вспомогательная функция для получения имени категории
function getCategoryName(category) {
    const names = {
        basic: "Основы SQL",
        join: "JOIN-запросы",
        subqueries: "Подзапросы"
    };
    return names[category] || category;
}

// Инициализация
document.addEventListener('DOMContentLoaded', function() {
    // По умолчанию загружаем первый тест
    loadTest('basic');
});