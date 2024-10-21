const questionsElement = document.getElementById('questions');
const submitButton = document.getElementById('submit');
const scoreElement = document.getElementById('score');

// Sample questions data
const questions = [
  { question: "What is the capital of France?", choices: ["Paris", "London", "Berlin", "Madrid"], answer: "Paris" },
  { question: "What is the highest mountain in the world?", choices: ["Everest", "Kilimanjaro", "Denali", "Matterhorn"], answer: "Everest" },
  { question: "What is the largest country by area?", choices: ["Russia", "China", "Canada", "United States"], answer: "Russia" },
  { question: "Which is the largest planet in our solar system?", choices: ["Earth", "Jupiter", "Mars"], answer: "Jupiter" },
  { question: "What is the capital of Canada?", choices: ["Toronto", "Montreal", "Vancouver", "Ottawa"], answer: "Ottawa" },
];

// Retrieve saved answers from session storage
let userAnswers = JSON.parse(sessionStorage.getItem('progress')) || [];

// Display the quiz questions and choices
function renderQuestions() {
  questionsElement.innerHTML = '';  // Clear any existing questions

  for (let i = 0; i < questions.length; i++) {
    const question = questions[i];
    const questionElement = document.createElement('div');
    const questionText = document.createTextNode(question.question);
    questionElement.appendChild(questionText);

    for (let j = 0; j < question.choices.length; j++) {
      const choice = question.choices[j];
      const choiceElement = document.createElement('input');
      choiceElement.setAttribute('type', 'radio');
      choiceElement.setAttribute('name', `question-${i}`);
      choiceElement.setAttribute('value', choice);

      if (userAnswers[i] === choice) {
        choiceElement.setAttribute('checked', true);
      }

      choiceElement.addEventListener('change', function () {
        userAnswers[i] = choice;
        sessionStorage.setItem('progress', JSON.stringify(userAnswers));
      });

      const choiceText = document.createTextNode(choice);
      questionElement.appendChild(choiceElement);
      questionElement.appendChild(choiceText);
    }

    questionsElement.appendChild(questionElement);
  }
}

// Calculate and display the score
function calculateScore() {
  let score = 0;
  for (let i = 0; i < questions.length; i++) {
    if (userAnswers[i] === questions[i].answer) {
      score++;
    }
  }

  const totalScore = `Your score is ${score} out of ${questions.length}.`;
  scoreElement.textContent = totalScore;
  localStorage.setItem('score', score); // Store the score in local storage
}

submitButton.addEventListener('click', calculateScore);

// Render questions on page load
renderQuestions();