<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\Connection;

class ArticleRepository {

    private Connection $database;

    public function __construct(Connection $database) {
        $this->database = $database;
    }

    public function getRecent(): array {
        return $this->database->findAll('SELECT * FROM articles ORDER BY created_at DESC');
    }

    public function getArticle(int $id): ?array {
        $articleData = $this->database->findOne('SELECT * FROM articles WHERE id = ?', [$id]);

        return $articleData;
    }

}
