<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" aria-current="page" href="/">Home</a>
                <a class="nav-link active" aria-current="page" href="/comments">Show comments</a>
                <a class="nav-link" aria-current="page" href="/comments/create">Create comment</a>
            </div>
        </div>
    </div>
</nav>
<div class="text-center m-5">
    <div class="mt-5 mb-2">
        <h1>Comments page</h1>
    </div>
    <?php for ($i = 0, $j = 0; $i < count($allComments); $i++, $j++): ?>
        <?php if($j == 0): ?>
            <div class="d-flex justify-content-between flex-lg-row flex-md-column">
        <?php endif; ?>
            <div class="col m-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        <?php if($j == 1): ?>
            </div>
            <?php $j = -1; ?>
        <?php endif; ?>
    <?php endfor; ?>
</div>
<nav class="mt-3">
    <ul class="pagination justify-content-center">
        <?php for($i = 1; $i <= $countPages; $i++): ?>
            <li class="page-item"><a class="page-link" href="/comments?page=<?= $i ?>"><?=$i ?></a></li>
        <?php endfor; ?>
    </ul>
</nav>










    <!--<div class="mt-5 mb-2">
        <h1>Comments page</h1>
    </div>
    <div class="d-flex justify-content-between flex-lg-row flex-md-column">
        <div class="col m-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col m-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col m-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between flex-lg-row flex-md-column">
        <div class="col m-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col m-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <div class="col m-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div> -->
    <!--<div class="card">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">title</th>
                <th scope="col">content</th>
                <th scope="col">created at</th>
                <th scope="col">#</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($allComments as $comment): ?>
                <tr>
                    <td>
                       <?= $comment->id ?>
                    </td>
                    <td>
                        <?= $comment->title ?>
                    </td>
                    <td class ="text-break">
                        <?= $comment->content ?>
                    </td>
                    <td>
                        <?= $comment->created_at ?>
                    </td>
                    <td>
                        <a class="btn btn-primary" href="/comment/<?= $comment->id?>">Open</a>
                        <button id="deleteButton" class="btn btn-primary" data-id="<?= $comment->id ?>"
                                type="button">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php for($i = 1; $i <= $countPages; $i++): ?>
                    <li class="page-item"><a class="page-link" href="/comments?page=<?= $i ?>"><?=$i ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="/assets/javascript/confirmDelete.js"></script>
</body>
</html>
