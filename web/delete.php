<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

$app = new App\App();

if (!$app->auth->isLoggedIn()) {
    $app->session->addFlash('error', 'Aby usuwać artykuły musisz być zalogowany');
    $app->router->redirect('login.php');
}



$article_id = (int) $_GET['id'];
$article = $app->repositories['article']->getArticle($article_id);
$user = $app->auth->getUser();
$user_id = $user['id'];
$article_author_id = $article['author_id'];




if ($user_id !== $article_author_id) {
    $app->session->addFlash('error', 'Możesz usuwać tylko swoje artykuły!');
    $app->router->redirect('login.php');
} else {
    $data = $app->database->delete($article_id);

    if ($data) {
        $app->session->addFlash('success', 'Usunięto artykuł');
        $app->router->redirect('index.php');
    } else {
        echo 'Coś poszło nie tak ';
    }
}
