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
        <a href="/comments/create">Create comment</a>
    </div>
</nav>
<div class="container">
    <div>
        <h1>Comments page</h1>
        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>content</th>
                <th>created at</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($allComments as $comment): ?>
                <tr>
                    <td>
                        <a href="/comment/<?= $comment->id?>"><?= $comment->id ?></a>
                    </td>
                    <td>
                        <?= $comment->title ?>
                    </td>
                    <td>
                        <?= $comment->content ?>
                    </td>
                    <td>
                        <?= $comment->created_at ?>
                    </td>
                    <td>
                        <button id="deleteButton" data-id="<?= $comment->id ?>" type="button">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="container">
            <?php for($i = 1; $i <= $countPages; $i++): ?>
                <div class="containerForLink">
                    <a href="/comments?page=<?= $i ?>"><?=$i ?></a>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div>
<script src="/assets/javascript/confirmDelete.js"></script>
</body>
</html>
