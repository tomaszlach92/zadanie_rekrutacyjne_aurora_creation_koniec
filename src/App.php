<?php

declare(strict_types=1);

namespace App;

use App\Config\Configuration;
use App\Database\Connection;
use App\Http\Session;
use App\Http\Router;
use App\Http\Request;
use App\Security\Auth;
use App\Repository\ArticleRepository;

class App {

    private Configuration $configuration;
    private Connection $database;
    private Session $session;
    private Router $router;
    private Request $request;
    private Auth $auth;
    private array $helpers;
    private array $repositories;

    public function __construct() {
        $this->configuration = new Configuration();

        $cfg = $this->configuration->getConfig('database');

        $this->database = new Connection(
                $cfg['server'],
                $cfg['host'],
                $cfg['database'],
                $cfg['user'],
                $cfg['password'],
        );

        $this->session = new Session();
        $this->router = new Router();
        $this->request = new Request();
        $this->auth = new Auth($this->database, $this->session);

        $this->helpers = [
            'flash_message' => new View\FlashMessageRenderer($this->session),
            'form' => new View\FormRenderer(),
            'template' => new View\TemplateRenderer($this),
        ];

        $this->repositories = [
            'article' => new ArticleRepository($this->database),
        ];
    }

    public function __get(string $name) {
        return $this->$name ?? null;
    }

}
