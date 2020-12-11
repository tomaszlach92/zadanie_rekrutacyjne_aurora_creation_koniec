<?php

declare(strict_types=1);

namespace App\Database;

class Connection {

    private string $server;
    private string $host;
    private string $database;
    private string $user;
    private string $password;
    private \PDO $conn;

    public function __construct(
            string $server,
            string $host,
            string $database,
            string $user,
            string $password
    ) {
        $this->server = $server;
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;

        $this->connect();
    }

    private function connect() {
        $this->conn = new \PDO($this->getDSN(), $this->user, $this->password);
    }

    private function getDSN(): string {
        return "{$this->server}:host={$this->host};dbname={$this->database}";
    }

    public function findAll(string $sql) {
        $stmt = $this->conn->prepare($sql);

        $result = $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function findOne(string $sql, array $params = []) {
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute($params);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data;
    }

    public function insert(string $table, array $data): ?int {

        $columns = join(',', array_keys($data));
        $values = join(',', array_values(array_fill(1, count($data), '?')));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ($values)";

        $stmt = $this->conn->prepare($sql);

        var_dump($sql);

        $result = $stmt->execute(array_values($data));

        if (!$result) {
            return null;
        }

        return (int) $this->conn->lastInsertId();
    }

    public function update(string $table, array $data, string $where = null) {
        $setParts = [];
        $values = [];

        foreach ($data as $key => $value) {
            $setParts[] = "{$key}=?";
            $values[] = $value;
        }
        $setClause = join(',', $setParts);

        $sql = "UPDATE {$table} SET {$setClause}";

        if ($where) {
            $sql .= 'WHERE ' . $where;
        }

        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute($values);

        return $result;
    }

}
