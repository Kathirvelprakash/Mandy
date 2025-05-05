<?php
declare(strict_types=1);

require_once 'Database.php';
require_once 'InputSanitizer.php';

class AppointmentFetcher
{
    private PDO $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->connect();
    }

    public function getAllAppointments(): array
    {
        $sql = "SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC";
        $stmt = $this->conn->query($sql);
        return $stmt ? $stmt->fetchAll() : [];
    }

    public function getAppointmentsByDateRange(string $from, string $to): array
    {
        $from = InputSanitizer::sanitizeDate($from);
        $to = InputSanitizer::sanitizeDate($to);

        $sql = "SELECT * FROM appointments 
                WHERE appointment_date BETWEEN :from AND :to 
                ORDER BY appointment_date DESC, appointment_time DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['from' => $from, 'to' => $to]);

        return $stmt ? $stmt->fetchAll() : [];
    }
}