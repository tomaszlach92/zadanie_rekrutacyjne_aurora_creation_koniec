<?php $app->helpers['template']->partial('header') ?>
<main role="main">

    <div class="container">
        <a class="navbar-brand" href="index.php">Strona główna</a>
        <div class="py-5 text-center">
            <h2>Logowanie</h2>
            <p class="lead">Zaloguj się aby móc dodawać artykuły</p>
        </div>

        <?= $app->helpers['flash_message']->printAll(); ?>

        <div class="col-md-8 offset-2 col-lg-8">
            <h4 class="mb-3">Twoje dane</h4>

            <form action="" method="POST" class="needs-validation" novalidate="">
                <form action="" method="POST" class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <?= $app->helpers['form']->printField('email', 'email', 'Email', $regData, $errors); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <?= $app->helpers['form']->printField('password', 'password', 'Hasło', $regData, $errors); ?>
                        </div>
                    </div>

                    <hr class="my-4">

                    <button class="w-100 btn btn-primary btn-lg" type="submit">Zaloguj się</button>
                </form>
        </div>
    </div>

</main>
<?php $app->helpers['template']->partial('footer') ?>

