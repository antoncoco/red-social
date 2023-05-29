<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Home <?php echo $this->data['user']->getUsername(); ?></h2>
        <?php require_once 'src/components/create.php'; ?>
        <?php
        $user = $this->data['user'];
        $posts = $this->data['posts'];
        foreach ($posts as $p) { ?>
            <div class="card mt-2">
                <div class="card-body">
                    <img class="rounded-circle" src="public/img/photos/<?php echo $p->getUser()->getProfile() ?>" width="32" />
                    <a class="link-dark" href="/profile/<?php echo $p->getUser()->getUsername()?>">
                        <?php echo $p->getUser()->getUsername() ?>
                    </a>
                </div>
                <img src="public/img/photos/<?php echo $p->getImage() ?>" width="100%" />
                <div class="card-body">

                    <div class="card-title">
                        <form action="/addLike" method="POST">
                            <input type="hidden" name="post_id" value="<?php echo $p->getId() ?>">
                            <input type="hidden" name="origin" value="home">
                            <button type="submit" class="btn btn-danger"><?php echo $p->getLikes(); ?> Likes</button>
                        </form>
                    </div>
                    <p class="card-text"><?php echo $p->getTitle() ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>