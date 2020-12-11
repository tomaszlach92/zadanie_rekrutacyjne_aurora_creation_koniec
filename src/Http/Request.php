<?php

declare(strict_types=1);

namespace App\Http;

use App\Utils\ParamsBag;

class Request {

    private ParamsBag $get;
    private ParamsBag $post;

    public function __construct() {
        $this->get = new ParamsBag(array_merge([], $_GET));
        $this->post = new ParamsBag(array_merge([], $_POST));
    }

    public function getMethod(): string {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isMethod(string $method): bool {
        return $this->getMethod() === $method;
    }

    public function post(): ParamsBag {
        return $this->post;
    }

    public function get(): ParamsBag {
        return $this->get;
    }

}
