<?php

require_once '../vendor/autoload.php';

$app = new App\App();

if ($app->auth->isLoggedIn()) {
    $app->router->redirect('index.php');
}

$errors = [];
$regData = [];

if ($app->request->isMethod('POST')) {

    $regData = $app->request->post()->getArray('reg') ?? [];
    $requiredFields = ['email', 'password'];


//czyszczenie danych z białych znaków
    foreach ($regData as $k => &$v) {
        $v = trim($v);
    }

//sprawdzam czy wszystkie pola są uzupełnione

    foreach ($requiredFields as $regFieldName) {
        if (empty($regData[$regFieldName])) {
            $errors[$regFieldName][] = 'To pole jest wymagane';
        }
    }

// sprawdzam poprawność email
    if (isset($regData['email'])) {
        if (!filter_var($regData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'Ten email jest niepoprawny';
        }
    }

    if (empty($errors)) {

        try {
            $app->auth->login($regData['email'], $regData['password']);

            $app->session->addFlash('success', 'Użytkownik zalogowany poprawnie');
            $app->router->redirect('index.php');
        } catch (\Exception $ex) {
            $errors['email'][] = $ex->getMessage();
        }
    }
}

$app->helpers['template']->render(
        'login',
        [
            'regData' => $regData,
            'errors' => $errors
        ]
);


