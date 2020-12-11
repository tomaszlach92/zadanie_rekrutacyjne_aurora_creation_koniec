<?php

require_once '../vendor/autoload.php';

$app = new App\App();

$errors = [];
$regData = [];

if ($app->auth->isLoggedIn()) {
    $app->router->redirect('index.php');
}

if ($app->request->isMethod('POST')) {
    $regData = $_POST['reg'] ?? [];
    $requiredFields = ['firstName', 'lastName', 'email', 'password'];

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

// sprawdzam poprawność i unikalność email
    if (isset($regData['email'])) {
        if (!filter_var($regData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'Ten email jest niepoprawny';
        } else {
            $data = $app->database->findOne('SELECT id FROM users WHERE email =?', [$regData['email']]);

            if (!empty($data)) {
                $errors['email'][] = 'Użytkownik o takim adresie email już istnieje';
            }
        }
    }

//spawdzam czy hasło nie jest za krótkie
    if (isset($regData['password'])) {
        if (strlen($regData['password']) < 8) {
            $errors['password'][] = 'Hasło musi składać się z przynajmniej 8 znaków';
        }
    }

//zapisywanie do bazy danych

    if (empty($errors)) {
//hashowanie hasła

        $passwordEncrypted = password_hash($regData['password'], PASSWORD_BCRYPT);

        $registrationSuccess = $app->database->insert(
                'users',
                [
                    'first_name' => $regData['firstName'],
                    'last_name' => $regData['lastName'],
                    'password' => $passwordEncrypted,
                    'email' => $regData['email'],
                ]
        );

        if ($registrationSuccess) {
            $app->session->addFlash(
                    'success',
                    'Użytkownik zarejestrowany się poprawnie. Możesz się <a href="/app/web/login.php">zalogować</a>.'
            );
        } else {
            $app->session->addFlash(
                    'error',
                    'Nie udało się zarejestrować'
            );
        }

        if ($registrationSuccess) {
            $app->router->redirect('register.php');
        }
    }
}
$app->helpers['template']->render(
        'register',
        [
            'regData' => $regData,
            'errors' => $errors
        ]
);

