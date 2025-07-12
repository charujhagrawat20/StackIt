function goToAsk() { window.location.href = "ask.html"; }
function logoutUser() { localStorage.removeItem("stackitUser"); window.location.href = "login.html"; }
function toggleProfileMenu() {
  let menu = document.getElementById("profileMenu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}
function manageProfile() { alert("Profile page coming soon!"); }

function loginUser() {
  let u = document.getElementById("username").value;
  let p = document.getElementById("password").value;
  if (u && p) {
    localStorage.setItem("stackitUser", u);
    window.location.href = "index.html";
  } else {
    document.getElementById("loginMsg").innerText = "Fill all fields.";
  }
}
function signupUser() {
  let u = document.getElementById("newUsername").value;
  let p = document.getElementById("newPassword").value;
  if (u && p) {
    alert("Account created! Now login.");
    window.location.href = "login.html";
  } else {
    document.getElementById("signupMsg").innerText = "Fill all fields.";
  }
}
function continueAsGuest() {
  localStorage.setItem("stackitUser", "Guest");
  window.location.href = "index.html";
}
function checkSession() {
  if (!localStorage.getItem("stackitUser")) window.location.href = "login.html";
}

let questions = JSON.parse(localStorage.getItem("stackitQuestions") || "[]");

function loadQuestions() {
  let qList = document.getElementById("questionsList");
  if (!qList) return;
  qList.innerHTML = questions.length ? "" : "<div>No questions yet.</div>";
  questions.forEach((q, i) => {
    let status = q.answers && q.answers.length ? "Answered" : "Unanswered";
    let div = document.createElement("div");
    div.className = "question-card";
    div.onclick = () => viewQuestion(i);
    div.innerHTML = `<h3>${q.title}</h3><p>${q.desc}</p><small>Tags: ${q.tags} | <b>${status}</b></small>`;
    qList.appendChild(div);
  });
}

function viewQuestion(idx) {
  localStorage.setItem("currentQuestion", idx);
  window.location.href = "question.html";
}

var quill;
document.addEventListener("DOMContentLoaded", function() {
  if (document.getElementById("editor")) {
    quill = new Quill('#editor', {
      theme: 'snow',
      modules: { toolbar: [['bold', 'italic', 'underline'], [{'list': 'ordered'}, {'list': 'bullet'}], ['link', 'image']] }
    });
  }
  if (document.getElementById("answerEditor")) {
    quill = new Quill('#answerEditor', {
      theme: 'snow',
      modules: { toolbar: [['bold', 'italic', 'underline'], [{'list': 'ordered'}, {'list': 'bullet'}], ['link', 'image']] }
    });
    loadQuestionDetail();
  }
});
function goToLogin() {
  window.location.href = "login.html";
}
function goToProfile() {
  window.location.href = "manage-profile.html";
}

function submitQuestion() {
  let title = document.getElementById("title").value.trim();
  let tags = document.getElementById("tags").value.trim();
  let desc = quill.root.innerHTML.trim();
  if (!title || !desc) {
    document.getElementById("questionOutput").innerText = "Please fill all fields.";
    return;
  }
  let question = { title, tags, desc, answers: [] };
  questions.unshift(question);
  localStorage.setItem("stackitQuestions", JSON.stringify(questions));
  setTimeout(() => window.location.href = "index.html", 1000);
}

function loadQuestionDetail() {
  let idx = localStorage.getItem("currentQuestion");
  if (idx === null) return;
  let q = questions[idx];
  document.getElementById("questionTitle").innerText = q.title;
  document.getElementById("questionDesc").innerHTML = q.desc;
  document.getElementById("questionTags").innerText = `Tags: ${q.tags}`;
  showAnswers(idx);
}

function submitAnswer() {
  let idx = localStorage.getItem("currentQuestion");
  if (idx === null) return;
  let answer = { text: quill.root.innerHTML, votes: 0 };
  questions[idx].answers.push(answer);
  localStorage.setItem("stackitQuestions", JSON.stringify(questions));
  loadQuestionDetail();
}

function showAnswers(idx) {
  let list = document.getElementById("answersList");
  if (!list) return;
  let answers = questions[idx].answers;
  list.innerHTML = answers.map((a, i) =>
    `<div class="answer-card">
      <div>${a.text}</div>
      <div>
        <span class="vote-btn" onclick="vote(${idx}, ${i}, 1)">⬆️</span>
        ${a.votes}
        <span class="vote-btn" onclick="vote(${idx}, ${i}, -1)">⬇️</span>
      </div>
    </div>`
  ).join('');
}
function vote(qIdx, aIdx, val) {
  questions[qIdx].answers[aIdx].votes += val;
  localStorage.setItem("stackitQuestions", JSON.stringify(questions));
  loadQuestionDetail();
}
