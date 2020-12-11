<?php

declare(strict_types=1);

namespace App\Security;

use App\Database\Connection;
use App\Http\Session;
use App\Exception\UserNotLoggedInException;

class Auth {

    private Connection $database;
    private Session $session;
    private string $sessionKey = 'auth_user';

    public function __construct(Connection $database, Session $session) {
        $this->database = $database;
        $this->session = $session;
    }

    public function login(string $email, string $password): bool {

        $data = $this->database->findOne(
                'SELECT * FROM users WHERE email = ?',
                [$email]
        );

        if (!$data) {
            throw new \Exception('Użytkownik o podanym adresie email nie istnieje');
        }

        if (!password_verify($password, $data['password'])) {
            throw new \Exception('Podałeś złe hasło');
        }

        $this->session->add($this->sessionKey, (int) $data['id']);

        return true;
    }

    public function isLoggedIn(): bool {
        return $this->session->has($this->sessionKey);
    }

    public function logout(): bool {
        if ($this->isLoggedIn()) {
            $this->session->remove($this->sessionKey);
            return true;
        }

        return false;
    }

    public function getUserId(): int {
        if (!$this->isLoggedIn()) {
            throw new UserNotLoggedInException();
        }

        return $this->session->get($this->sessionKey);
    }

    public function getUser(): array {
        $userId = $this->getUserId();

        $data = $this->database->findOne(
                'SELECT * FROM users WHERE id = ?',
                [$userId]
        );

        return $data;
    }

}
