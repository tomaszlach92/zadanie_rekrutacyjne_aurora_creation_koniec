<?php

declare(strict_types=1);

namespace App\Utils;

class ParamsBag {

    private array $params;

    public function __construct(array $params = []) {
        $this->params = $params;
    }

    public function all(): array {
        return $this->params;
    }

    public function getInt(string $key): ?int {
        if (!isset($this->params[$key])) {
            return null;
        }

        return (int) $this->params[$key];
    }

    public function getArray(string $key): array {
        if (!isset($this->params[$key])) {
            return null;
        }

        return $this->params[$key];
    }

}
