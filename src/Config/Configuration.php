<?php

declare(strict_types=1);

namespace App\Config;

class Configuration {

    private array $config = [
        'database' => [
            'server' => 'mysql',
            'host' => 'localhost',
            'database' => 'zadanie',
            'user' => 'zadanie',
            'password' => 'zadanie'
        ],
    ];

    public function getConfig(string $name) {
        return $this->config[$name] ?? null;
    }

}
