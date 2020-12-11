<?php

declare(strict_types=1);

namespace App\Http;

class Session {

    public function __construct() {
        session_start();
    }

    public function add(string $name, $value) {
        $_SESSION[$name] = $value;
    }

    public function get(string $name) {
        return $_SESSION[$name] ?? null;
    }

    public function pop(string $name) {
        $value = $this->get($name);

        $this->remove($name);

        return $value;
    }

    public function has(string $name): bool {
        return isset($_SESSION[$name]);
    }

    public function remove(string $name) {
        unset($_SESSION[$name]);
    }

    public function addFlash(string $type, string $message) {
        $_SESSION['flash'][$type][] = $message;
    }

    public function getFlashes(string $type): array {
        $flashes = $_SESSION['flash'][$type] ?? [];

        unset($_SESSION['flash'][$type]);

        return $flashes;
    }

}
