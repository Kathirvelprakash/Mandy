<?php
declare(strict_types=1);

require_once 'Database.php';
require_once 'InputSanitizer.php';

class BookingHandler
{
    private PDO $conn;

    public function __construct(Database $db)
    {
        $this->conn = $db->connect();
    }

    public function saveBooking(array $postData): string
    {
        $firstName = InputSanitizer::sanitize($postData['first_name'] ?? '');
        $lastName = InputSanitizer::sanitize($postData['last_name'] ?? '');
        $email = InputSanitizer::sanitize($postData['email'] ?? '');
        $phone = InputSanitizer::sanitize($postData['phone'] ?? '');
        $comments = InputSanitizer::sanitize($postData['comments'] ?? '');
        $services = isset($postData['services']) ? InputSanitizer::sanitizeArray($postData['services']) : '';
        $vehicle = InputSanitizer::sanitize($postData['vehicle'] ?? '');
        $appointmentDate = InputSanitizer::sanitize($postData['appointment_date'] ?? '');
        $appointmentTime = InputSanitizer::sanitize($postData['appointment_time'] ?? '');

        try {
            $stmt = $this->conn->prepare("
                INSERT INTO appointments (first_name, last_name, email, phone, comments, services, vehicle, appointment_date, appointment_time)
                VALUES (:first_name, :last_name, :email, :phone, :comments, :services, :vehicle, :appointment_date, :appointment_time)
            ");

            $stmt->execute([
                ':first_name' => $firstName,
                ':last_name' => $lastName,
                ':email' => $email,
                ':phone' => $phone,
                ':comments' => $comments,
                ':services' => $services,
                ':vehicle' => $vehicle,
                ':appointment_date' => $appointmentDate,
                ':appointment_time' => $appointmentTime
            ]);

            return "✅ $firstName Booking submitted successfully!";
        } catch (PDOException $e) {
            return "❌ Error submitting booking: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}