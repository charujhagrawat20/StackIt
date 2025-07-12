<?php
$answers = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answer = $_POST['answer'] ?? '';
    if (!empty($answer)) {
        $answers[] = $answer;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Question - StackIt</title>

  <!-- Quill core styles -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/quill-emoji@0.1.7/dist/quill-emoji.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>

  <nav>
    <h1>StackIt</h1>
    <button onclick="location.href='index.html'">Home</button>
  </nav>

  <div class="question-detail">
    <h2 id="questionTitle">Example Question Title</h2>
    <div id="questionDesc">This is a placeholder question description.</div>
    <small id="questionTags">php, html</small>
  </div>

  <div class="answer-form">
    <form method="POST" onsubmit="return handleFormSubmit();">
      <div id="answerEditor" style="height:120px;"></div>
      <input type="hidden" name="answer" id="answer">
      <button type="submit">Submit Answer</button>
    </form>
  </div>

  <div class="answers" id="answersList">
    <?php foreach ($answers as $a): ?>
      <div class="answer"><?php echo $a; ?></div>
    <?php endforeach; ?>
  </div>

  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/quill-emoji@0.1.7/dist/quill-emoji.min.js"></script>

  <script>
    var quill = new Quill('#answerEditor', {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, false] }],
          ['bold', 'italic', 'underline'],
          ['emoji'],
          ['link', 'image'],
          [{ 'list': 'ordered' }, { 'list': 'bullet' }]
        ],
        'emoji-toolbar': true,
        'emoji-textarea': false,
        'emoji-shortname': true
      }
    });

    function handleFormSubmit() {
      document.getElementById("answer").value = quill.root.innerHTML;
      return true;
    }
  </script>

</body>
</html>
