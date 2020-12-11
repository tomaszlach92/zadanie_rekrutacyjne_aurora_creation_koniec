<?php $app->helpers['template']->partial('header') ?>
<main role="main">

    <div class="container">
        <a class="navbar-brand" href="index.php">Strona główna</a>
        <div class="py-5 text-center">
            <h2>Rejestracja</h2>
            <p class="lead">Zarejestruj się aby móc dodawać artykuły</p>
        </div>

        <?= $app->helpers['flash_message']->printAll(); ?>

        <div class="col-md-8 offset-2 col-lg-8">
            <h4 class="mb-3">Twoje dane</h4>

            <form action="" method="POST" class="needs-validation" novalidate="">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <?= $app->helpers['form']->printField('text', 'firstName', 'Imię', $regData, $errors) ?>
                    </div>

                    <div class="col-sm-6">
                        <?= $app->helpers['form']->printField('text', 'lastName', 'Nazwisko', $regData, $errors) ?>
                    </div>

                    <div class="col-12">
                        <?= $app->helpers['form']->printField('email', 'email', 'Email', $regData, $errors) ?>
                    </div>

                    <div class="col-12">
                        <?= $app->helpers['form']->printField('password', 'password', 'Hasło', $regData, $errors) ?>
                    </div>

                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-lg" type="submit">Zarejestruj się</button>
            </form>
        </div>
    </div>

</main>
<?php $app->helpers['template']->partial('footer') ?>
