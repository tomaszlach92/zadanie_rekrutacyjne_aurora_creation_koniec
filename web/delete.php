<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

$app = new App\App();

$id = $_GET['id'];

$data = $app->database->delete($id);

if ($data) {
    $app->session->addFlash('success', 'Usunięto artykuł');
    $app->router->redirect('index.php');
} else {
    echo 'Coś poszło nie tak ';
}

