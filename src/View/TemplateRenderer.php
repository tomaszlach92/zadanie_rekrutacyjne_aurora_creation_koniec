<?php

declare(strict_types=1);

namespace App\View;

use App\App;

class TemplateRenderer {

    private App $app;
    private string $templatesDir;

    public function __construct(App $app) {

        $this->app = $app;
        $this->templatesDir = __DIR__ . '/../templates';
    }

    public function render(string $name, array $params = []) {

        $app = $this->app;
        extract($params);
        include_once $this->templatesDir . '/' . $name . '.php';
    }

    public function partial(string $name) {
        include_once $this->templatesDir . '/partials/' . $name . '.php';
    }

}
