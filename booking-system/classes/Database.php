<?php

declare(strict_types=1);

class Database
{
    private string $host = 'localhost';
    private string $dbName = 'service_booking_db';
    private string $username = 'root';
    private string $password = '';
    private ?PDO $connection = null;

    public function connect(): ?PDO
    {
        $this->connection = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Connection Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
        }

        return $this->connection;
    }

    public function close(): void
    {
        $this->connection = null;
    }
}