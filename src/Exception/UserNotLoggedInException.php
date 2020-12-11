<?php

declare(strict_types=1);

namespace App\Exception;

class UserNotLoggedInException extends \Exception {

    public function __construc($message = 'Użytkownik nie jest zalogowany') {
        parent::__construct($message);
    }

}
