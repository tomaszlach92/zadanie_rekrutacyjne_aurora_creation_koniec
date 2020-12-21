<?php

declare(strict_types=1);

namespace App\Exception;

class UserNotLoggedInException extends \Exception {

    public function __construct($message = 'Użytkownik nie jest zalogowany') {
        parent::__construct($message);
    }

}
