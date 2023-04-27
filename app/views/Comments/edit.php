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
    <form name="commentsForm" method="post" action="/comments/update" id="ddd">
        <input id="id" name="id" type="text" hidden value="<?=$comment->id ?>"/>
        <div>
            <label for="title">Title:</label>
        </div>
        <input id="title" name="title" type="text" value="<?=$comment->title ?>"/>
        <div>
            <label for="content">Content:</label>
        </div>
        <textarea name="content" id="content" cols="30" rows="10"><?=$comment->content ?></textarea>
        <div>
            <button id="submitComment" type="submit">Submit</button>
        </div>
    </form>
</div>
</body>
</html>