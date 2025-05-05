<?php
require_once 'classes/booking.php';
require_once 'classes/Database.php';

$db = new Database();
$booking = new AppointmentFetcher($db);

$appointments = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['from_date']) && !empty($_POST['to_date'])) {
    $appointments = $booking->getAppointmentsByDateRange($_POST['from_date'], $_POST['to_date']);
} else {
    $appointments = $booking->getAllAppointments();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/form-scheduler.css">
    <link rel="stylesheet" href="assets/css/handler.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>View Bookings</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
    <div class="con">
        <div class="con-data">
            <h2>📅 Filter Bookings by Date</h2>
            <form method="POST">
                <label>From: <input type="date" name="from_date" required></label>
                <label>To: <input type="date" name="to_date" required></label>
                <input type="submit" value="Filter">
            </form>

            <?php if (!empty($appointments)): ?>
                <h3>🔍 Showing <?= count($appointments) ?> Booking(s)</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email / Phone</th>
                            <th>Vehicle</th>
                            <th>Services</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $app): ?>
                            <tr>
                                <td><?= htmlspecialchars($app['id']) ?></td>
                                <td><?= htmlspecialchars($app['first_name'] . ' ' . $app['last_name']) ?></td>
                                <td><?= htmlspecialchars($app['email']) ?><br><?= htmlspecialchars($app['phone']) ?></td>
                                <td><?= htmlspecialchars($app['vehicle']) ?></td>
                                <!-- echo "<li>" . html_entity_decode($service['service_name']) . "</li>"; -->

                                <td><?= html_entity_decode($app['services']) ?></td>
                                <td><?= htmlspecialchars($app['appointment_date']) ?></td>
                                <td><?= htmlspecialchars($app['appointment_time']) ?></td>
                                <td><?= htmlspecialchars($app['comments']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>🚫 No bookings found for the selected dates.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>

</body>
</html>