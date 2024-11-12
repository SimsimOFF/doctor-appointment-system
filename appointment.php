<?php
// created by Simon MELIK-KAZARYAN

// Приклад збереження даних (для реального проекту можна використовувати базу даних або файли JSON)
$appointments = json_decode(file_get_contents('data/appointments.json'), true);

// Перевірка, чи була надіслана форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_time = $_POST['time'];
    $patient_name = $_POST['patient_name'];
    $patient_phone = $_POST['patient_phone'];

    // Оновлення бронювання
    foreach ($appointments as &$appointment) {
        if ($appointment['time'] === $appointment_time && $appointment['status'] == 'available') {
            $appointment['status'] = 'booked';
            $appointment['patient_name'] = $patient_name;
            $appointment['patient_phone'] = $patient_phone;
            break;
        }
    }
    // Збереження оновлених даних
    file_put_contents('data/appointments.json', json_encode($appointments, JSON_PRETTY_PRINT));
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запис на прийом</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="appointment-container">
        <h2>Запис на прийом до лікаря</h2>

        <form action="appointment.php" method="POST">
            <label for="time">Час прийому:</label>
            <select name="time" id="time" required>
                <?php foreach ($appointments as $appointment): ?>
                    <?php if ($appointment['status'] == 'available'): ?>
                        <option value="<?php echo $appointment['time']; ?>"><?php echo $appointment['time']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label for="patient_name">Ваше ім'я:</label>
            <input type="text" name="patient_name" id="patient_name" placeholder="Введіть ваше ім'я" required>

            <label for="patient_phone">Телефон:</label>
            <input type="text" name="patient_phone" id="patient_phone" placeholder="Введіть ваш телефон" required>

            <button type="submit" class="submit-btn">Забронювати</button>
        </form>

        <!-- Посилання на головну сторінку -->
        <div class="back-to-home">
            <a href="index.php" class="back-btn">Повернутись на головну</a>
        </div>
    </div>
</body>
</html>
