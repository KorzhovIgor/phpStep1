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
    <div class="containerForLink">
        <a href="/comments/edit/<?= $comment->id ?>">Edit</a>
    </div>
</nav>
<div class="container">
    <div>
        <h1>Show page</h1>
        <h1>ID: <?= $comment->id ?></h1>
        <h1>Title: <?= $comment->title ?></h1>
        <h1>Content: <?= $comment->content ?></h1>
        <h1>Created: <?= $comment->created_at ?></h1>
    </div>
</div>
<script src=""></script>
</body>
</html>
