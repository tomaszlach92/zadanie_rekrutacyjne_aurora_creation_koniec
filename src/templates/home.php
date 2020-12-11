<?php $app->helpers['template']->partial('header') ?>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <div class="navbar-nav mr-auto">
            <a class="navbar-brand" href="index.php">Strona główna</a>
        </div>

        <?php
        if ($app->auth->isLoggedIn()):
            $user = $app->auth->getUser();
            ?>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= "{$user['first_name']} {$user['last_name']}"; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="article-form.php" class="dropdown-item">Dodaj artykuł</a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item">Wyloguj</a>
                </div>
            </div>
        <?php else: ?>
            <div class="btn-group" role="group">
                <a href="login.php"class="btn btn-primary">Zaloguj</a>
                <a href="register.php" class="btn btn-primary">Zarejestruj się</a>
            </div>
        <?php endif; ?>

    </div>
</nav>

<?= $app->helpers['flash_message']->printAll(); ?>

<main role="main">
    <div class="album py-5 bg-light">
        <?php foreach ($app->repositories['article']->getRecent() as $article): ?>
            <div class="container">
                <div class="panel panel-default border">
                    <div class="panel-body my-5">
                        <div class="col-md-12">
                            <h2><?= $article['title'] ?></h2>
                            <p>Id autora: <?= $article['author_id'] ?></p>
                            <hr>
                            <?php if ($article['updated_at']): ?>
                                <p>Edytowany: <?= $article['updated_at'] ?></p>
                            <?php else: ?>
                                <p>Utworzono <?= $article['created_at'] ?></p>
                            <?php endif; ?>
                            <hr>
                            <p><?= $article['text'] ?></p>
                            <?php
                            if ($app->auth->isLoggedIn() && $article['author_id'] === $user['id']):
                                ?>
                                <div class="pull-right">
                                    <a href="article-form.php?id=<?= $article['id'] ?>">
                                        <button type="button" class="btn btn-primary">
                                            <span class="btn-small btn-google">Edytuj<i class="fa fa-chevron-right"></i></span>
                                        </button>
                                    </a>
                                    <a href="delete.php?id=<?= $article['id'] ?>">
                                        <button type="button" class="btn btn-danger">
                                            <span class="btn-small btn-google">Usuń<i class="fa fa-chevron-right"></i></span>
                                        </button>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Wróć na górę</a>
        </p>
    </div>
</footer>
<?php $app->helpers['template']->partial('footer') ?>