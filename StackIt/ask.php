<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"] ?? '';
    $description = $_POST["description"] ?? '';
    $tags = $_POST["tags"] ?? '';

    echo "<h2>Question Submitted</h2>";
    echo "<strong>Title:</strong> " . htmlspecialchars($title) . "<br>";
    echo "<strong>Description:</strong><br>" . $description . "<br>";
    echo "<strong>Tags:</strong> " . htmlspecialchars($tags);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ask a Question</title>
  <link href="style.css" rel="stylesheet"/>
  
  <!-- Quill Core -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"/>

  <!-- Quill Emoji CSS -->
  <link href="https://cdn.jsdelivr.net/npm/quill-emoji@0.1.7/dist/quill-emoji.css" rel="stylesheet"/>
</head>
<body>
  <nav>
    <h1>StackIt</h1>
    <div class="nav-right">
      <button onclick="location.href='index.html'">Home</button>
    </div>
  </nav>

  <div class="form-container">
    <form method="POST" onsubmit="return prepareForm();">
      <input type="text" name="title" placeholder="Title" id="title" required>
      
      <!-- Quill Editor -->
      <div id="editor" style="height: 200px;"></div>
      <input type="hidden" name="description" id="description">

      <input type="text" name="tags" placeholder="Tags (comma separated)" id="tags">
      <button type="submit">Submit</button>
    </form>
  </div>

  <!-- Quill Core JS -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <!-- Quill Emoji JS -->
  <script src="https://cdn.jsdelivr.net/npm/quill-emoji@0.1.7/dist/quill-emoji.min.js"></script>

  <script>
    const quill = new Quill('#editor', {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'align': [] }],
          ['blockquote', 'code-block'],
          [{ 'list': 'ordered' }, { 'list': 'bullet' }],
          ['link', 'image', 'video'],
          ['emoji'],
          ['clean']
        ],
        'emoji-toolbar': true,
        'emoji-textarea': false,
        'emoji-shortname': true
      }
    });

    function prepareForm() {
      document.getElementById('description').value = quill.root.innerHTML;
      return true;
    }
  </script>
</body>
</html>
