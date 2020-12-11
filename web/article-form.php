<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

$app = new App\App();

$formData = [];
$errors = [];

if (!$app->auth->isLoggedIn()) {
    $app->session->addFlash('error', 'Aby dodać lub edytować artykuł musisz być zalogowanym użytkownikiem');
    $app->router->redirect('login.php');
}

$articleId = $app->request->get()->getInt('id');
$articleData = [];
$mode = 'create';
$currentDate = new \DateTime();

if ($articleId) {
    $articleData = $app->repositories['article']->getArticle($articleId);
    $mode = 'edit';

    if (!$articleData) {
        $app->session->addFlash('error', 'Nie ma takiego artykułu');
        $app->router->redirect('index.php');
    }
}

if ($app->request->isMethod('POST')) {

    $formData = $app->request->post()->getArray('article-form');

    if ('create' == $mode) {
        $articleData = $formData;
        $formData = $_POST['article-form'] ?? [];
        $requiredFields = ['title', 'text'];

        $formData['title'] = trim($formData['title']);
        $formData['text'] = trim($formData['text']);


        foreach ($requiredFields as $regFieldName) {
            if (empty($formData[$regFieldName])) {
                $errors[$regFieldName][] = 'To pole jest wymagane';
            }
        }

        if (isset($formData['title'])) {
            if (strlen($formData['title']) > 32) {
                $errors['title'][] = 'Tytuł może składać się z 32 znaków';
            }
        }

        if (isset($formData['text'])) {
            if (strlen($formData['text']) > 1000) {
                $errors['text'][] = 'Artykuł może składać się z maksymalnie 1000 znaków.';
            }
        }

        if (empty($errors)) {

            $user = $app->auth->getUser();
            $userId = $user['id'];

            $newArticleId = $app->database->insert(
                    'articles',
                    [
                        'title' => $formData['title'],
                        'text' => $formData['text'],
                        'created_at' => $currentDate->format('Y-m-d H:i:s'),
                        'author_id' => $userId,
                    ]
            );

            if ($newArticleId) {
                $app->session->addFlash(
                        'success',
                        'Dodałeś atrykuł. Przejdź do <a href="index.php">strony głównej</a>.'
                );

                $app->router->redirect('article-form.php');
            }
        } else {
            $app->session->addFlash(
                    'error',
                    'Nie udało dodać artykułu. Popraw błędy formularzu.'
            );
        }
    } else if ('edit' == $mode) {
        $result = $app->database->update(
                'articles',
                [
                    'title' => $formData['title'],
                    'text' => $formData['text'],
                    'updated_at' => $currentDate->format('Y-m-d H:i:s'),
                ],
                sprintf('id=%d', $articleId)
        );

        $app->session->addFlash('success', 'Edycja przebiegła poprawnie');
        $app->router->redirect(sprintf('article-form.php?id=%d', $articleId));
    }
}

$app->helpers['template']->render(
        'article-form',
        [
            'mode' => $mode,
            'articleData' => $articleData,
            'errors' => $errors,
        ]
);
