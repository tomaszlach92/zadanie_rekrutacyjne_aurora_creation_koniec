<?php

require_once '../vendor/autoload.php';

$app = new App\App();

if ($app->auth->logout()) {
    $app->session->addFlash('success', 'Użytkownik poprawnie wylogowany');
}

$app->router->redirect('index.php');
