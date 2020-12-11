<?php $app->helpers['template']->partial('header') ?>

<main role="main">
    <div class="container">
        <a class="navbar-brand" href="index.php">Strona główna</a>
        <?= $app->helpers['flash_message']->printAll(); ?>
        <div class="py-5 text-center">
            <?php if ('edit' === $mode): ?>
                <h2>Edytowanie artykułu</h2>
                <p class="lead">Edytuj swój wpis</p>
            <?php else: ?>
                <h2>Dodawanie artykułu</h2>
                <p class="lead">Dodaj nowy wpis</p>
            <?php endif; ?>
        </div>

        <div class="col-md-8 offset-2 col-lg-8">
            <h4 class="mb-3">Informacje o artykule:</h4>

            <form action="" method="POST" class="needs-validation" novalidate="">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="article-form-title">Tytuł:</label>
                        <input id="article-form-title" type="text" class="form-control <?= !empty($errors['title']) ? ' is-invalid' : '' ?>" name="article-form[title]" value="<?= $articleData['title'] ?? '' ?>" required="">
                        <?php $app->helpers['form']->articlePrintErrors('title', $errors) ?>
                    </div>

                    <div class="col-12">
                        <label for="article-form-text">Treść:</label>
                        <textarea id="article-form-text" class="form-control <?= !empty($errors['text']) ? 'is-invalid' : '' ?>" name="article-form[text]"><?= $articleData['text'] ?? '' ?></textarea>
                        <?php $app->helpers['form']->articlePrintErrors('text', $errors) ?>
                    </div>

                    <hr class="my-4">

                    <button class="btn btn-primary m-3" type="submit">Dodaj</button>
            </form>
        </div>

    </div>
</main>

<?php $app->helpers['template']->partial('footer') ?>

