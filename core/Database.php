<?php

namespace Core;

use PDO;

class Database
{

    private PDO $connection;
    private \PDOStatement|false $statement;

    public function __construct()
    {

        $this->connection = new PDO("mysql:host=" . config('database.host') . ";dbname=" . config('database.name'), config("database.username"), config("database.password"));

    }

    public function query(string $query, ?array $params = null): static
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function fetchAll(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch(): array|false
    {
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    public function reset(): void
    {
        $this->connection->exec("TRUNCATE TABLE users");
        // Add more tables to truncate if needed
    }


}
