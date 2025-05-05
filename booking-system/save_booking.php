<?php
require_once 'classes/Database.php';
require_once 'classes/InputSanitizer.php';
require_once 'classes/BookingHandler.php';

$bookingHandler = new BookingHandler(new Database());
$message = $bookingHandler->saveBooking($_POST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Status</title>
  <link rel="stylesheet" href="assets/css/form-scheduler.css">
</head>
<body>

<?php if ($message): ?>
  <div class="message-container">
    <?= $message ?>
    <?php if (strpos($message, 'successfully') !== false): ?>
      <div class="countdown-msg">
        Redirecting in <span id="countdown">5</span> seconds...
      </div>
      <script>
        let counter = 5;
        const countdownElement = document.getElementById("countdown");
        const interval = setInterval(() => {
          counter--;
          countdownElement.textContent = counter;
          if (counter === 0) {
            clearInterval(interval);
            window.location.href = "form-handler.php";
          }
        }, 1000);
      </script>
    <?php endif; ?>
  </div>
<?php endif; ?>

</body>
</html>