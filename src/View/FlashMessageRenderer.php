<?php

declare(strict_types=1);

namespace App\View;

use App\Http\Session;

class FlashMessageRenderer {

    private Session $session;
    private array $alertClassMapping = [
        'success' => 'success',
        'error' => 'danger',
    ];
    private $types = [
        'success',
        'error',
    ];

    public function __construct(Session $session) {
        $this->session = $session;
    }

    public function printByType(string $type): string {
        $html = [];

        $messages = $this->session->getFlashes($type);

        $alertCssClass = $this->getAlertClassByType($type);

        foreach ($messages as $message) {
            $html[] = '<div class="alert alert-' . $alertCssClass . '" role="alert">' . $message . '</div>';
        }

        return join("\n", $html);
    }

    public function printAll(): string {
        $html = [];

        foreach ($this->types as $type) {
            $html[] = $this->printByType($type);
        }

        return join("\n", $html);
    }

    private function getAlertClassByType(string $type): ?string {
        return $this->alertClassMapping[$type] ?? null;
    }

}
