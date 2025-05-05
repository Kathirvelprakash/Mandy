<?php

require_once 'Database.php';

class ServiceType
{
    private PDO $conn;
    public function __construct()
    {
        try {
            $this->conn = (new Database())->connect();
        } catch (Exception $e) {
            error_log("Error in ServiceType constructor: " . $e->getMessage());
            throw new Exception("Unable to connect to the database.");
        }
    }

    public function getAllServices(): array
    {
        try {
            $sql = 'SELECT * FROM services';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching services: " . $e->getMessage());
            throw new Exception("Error fetching services.");
        }
    }
}
?>