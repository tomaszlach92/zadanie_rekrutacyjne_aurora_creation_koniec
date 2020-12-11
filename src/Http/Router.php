<?php

declare(strict_types=1);

namespace App\Http;

class Router {

    public function redirect(string $path) {
        header('Location: ' . $path);
        die;
    }

}
