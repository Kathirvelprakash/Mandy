<?php
require_once 'classes/ServiceType.php';
require_once 'classes/CarModel.php';

$serviceObj = new ServiceType();
$services = $serviceObj->getAllServices();

$vehicleObj = new CarModel();
$vehicles = $vehicleObj->getAllVehicles();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Service Booking Form</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/form-scheduler.css">
  <link rel="stylesheet" href="assets/css/responsive.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
  <script defer src="assets/js/main.js"></script>
  <link rel="stylesheet" href="">
</head>

<body>

<?php include 'includes/header.php'; ?>

  <form action="save_booking.php" method="POST" id="bookingForm">
    <div class="container">
      <div class="form-section">
        <div class="step-title"><span>1</span>Contact Information</div>
        <div class="row">
          <input type="text" name="first_name" id="first_name" placeholder="First Name" required>
          <span class="error-msg" id="first_name_error"></span>

          <input type="text" name="last_name" placeholder="Last Name" required>
        </div>

        <input type="email" name="email" id="email" placeholder="Email" required>
        <span class="error-msg" id="email_error"></span>

        <input type="tel" name="phone" id="phone" placeholder="Phone Number" required pattern="[0-9]{10}" maxlength="10">
        <span class="error-msg" id="phone_error"></span>

        <textarea name="comments" placeholder="Comments"></textarea>

        <div class="step-title"><span>2</span>Select Your Service</div>
        <div class="checkbox-group">
          <?php foreach ($services as $service): ?>
            <label>
              <input type="checkbox" name="services[]" value="<?= htmlspecialchars($service['service_name']) ?>">
              <?= htmlspecialchars($service['service_name']) ?>
            </label>
          <?php endforeach; ?>
        </div>

        <div class="step-title"><span>3</span>Verify Your Car Information</div>
        <div class="dropdown-vehicle">
          <select name="vehicle" required>
            <option value="">— Select a Vehicle —</option>
            <?php foreach ($vehicles as $v): ?>
              <option value="<?= htmlspecialchars($v['name']) ?>">
                <?= htmlspecialchars($v['id']) ?> - <?= htmlspecialchars($v['name']) ?> <?= $v['tire_info'] ? '(' . htmlspecialchars($v['tire_info']) . ')' : '' ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="date-time">
        <h3>Date and Time</h3>
        <div class="row">
          <div class="input-wrapper">
            <input id="datePicker" name="appointment_date" placeholder="Choose Date" readonly required />
            <i class="fa-regular fa-calendar calendar-icon"></i>
          </div>

          <div class="input-wrapper">
            <select id="timePicker" name="appointment_time" required>

          </select>
          </div>

        </div>
        <button type="submit">Book Appointment</button>
      </div>
    </div>
  </form>

  <script>

  document.addEventListener("DOMContentLoaded", function () {
    const timePicker = document.getElementById("timePicker");
    const now = new Date();
    const currentHour = now.getHours();
    const currentMinute = now.getMinutes();

    const times = [
      { label: "8:00 AM", value: "08:00", hour: 8 },
      { label: "9:00 AM", value: "09:00", hour: 9 },
      { label: "10:00 AM", value: "10:00", hour: 10 },
      { label: "11:00 AM", value: "11:00", hour: 11 },
      { label: "12:00 PM", value: "12:00", hour: 12 },
      { label: "1:00 PM", value: "13:00", hour: 13 },
      { label: "2:00 PM", value: "14:00", hour: 14 },
      { label: "3:00 PM", value: "15:00", hour: 15 },
      { label: "4:00 PM", value: "16:00", hour: 16 }
    ];

    let defaultOptionSet = false;

    times.forEach(time => {
      const option = document.createElement("option");
      option.value = time.value;
      option.textContent = time.label;

      const showAll = currentHour > 16 || (currentHour === 16 && currentMinute >= 10);

      if (showAll) {
        if (!defaultOptionSet) {
          option.selected = true;
          defaultOptionSet = true;
        }
      } else {
        if (currentHour > time.hour || (currentHour === time.hour && currentMinute >= 10)) {
          option.disabled = true;
        } else if (!defaultOptionSet) {
          option.selected = true;
          defaultOptionSet = true;
        }
      }

      timePicker.appendChild(option);
    });
  });

    document.addEventListener("DOMContentLoaded", function () {
      const now = new Date();
      const currentHour = now.getHours();
      const currentMinute = now.getMinutes();

      const isAfterCutoff = currentHour > 15 || (currentHour === 15 && currentMinute >= 30  );
      const today = new Date();
      const defaultDate = isAfterCutoff ? new Date(today.getTime() + 86400000) : today;

      flatpickr("#datePicker", {
        dateFormat: "Y-m-d",
        minDate: defaultDate,
        defaultDate: defaultDate,
        monthSelectorType: "static"
      });

      const formFields = {
        first_name: {
          pattern: /^[A-Za-z\s]+$/,
          errorMsg: "First name must contain only letters."
        },
        email: {
          pattern: /^[^@\s]+@[^@\s]+\.[^@\s]+$/,
          errorMsg: "Enter a valid email address."
        },
        phone: {
          pattern: /^[0-9]{10}$/,
          errorMsg: "Phone number must be exactly 10 digits."
        },
      };

      Object.entries(formFields).forEach(([id, { pattern, errorMsg }]) => {
        const field = document.getElementById(id);
        const errorElement = document.getElementById(`${id}_error`);
        field.addEventListener("blur", () => {
          if (!pattern.test(field.value)) {
            errorElement.textContent = errorMsg;
          } else {
            errorElement.textContent = '';
          }
        });
      });

      document.getElementById("bookingForm").addEventListener("submit", function (e) {
        let valid = true;
        Object.entries(formFields).forEach(([id, { pattern }]) => {
          const field = document.getElementById(id);
          if (!pattern.test(field.value)) {
            valid = false;
            document.getElementById(`${id}_error`).textContent = formFields[id].errorMsg;
          }
        });
        if (!valid) e.preventDefault();
      });
    });
  </script>
  
<?php include 'includes/footer.php'; ?>

</body>
</html>