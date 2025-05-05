<?php
class CarModel
{
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = (new Database())->connect();
        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getAllVehicles()
    {
        $sql = "SELECT * FROM vehicles";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching vehicles: " . $e->getMessage());
        }
    }
}
?>