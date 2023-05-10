<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyApp</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="container">
    <div class="containerForLink">
        <a href="/">App</a>
    </div>
    <div class="containerForLink">
        <a href="/comments">Comments</a>
    </div>
</nav>
<div class="container">
    <form name="commentsForm" method="post" action="/comments/store" id="ddd">
        <div>
            <label for="title">Title:</label>
        </div>
        <input id="title" name="title" type="text" required/>
        <div>
            <label for="content">Content:</label>
        </div>
        <textarea name="content" id="content" cols="30" required rows="10"></textarea>
        <div>
            <button id="submitComment" type="submit">Submit</button>
        </div>
    </form>
</div>
<script src="/assets/javascript/form.js"></script>
</body>
</html>
