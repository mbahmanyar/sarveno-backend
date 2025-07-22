<?php

namespace Core;

use PDO;

class Database
{

    private PDO $connection;
    private \PDOStatement|false $statement;

    public function __construct()
    {

        $this->connection = new PDO('mysql:host=localhost;dbname=sarveno', 'root', 'Meb@6057720');

//        $items = $statement->fetchAll(PDO::FETCH_ASSOC);
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


}
