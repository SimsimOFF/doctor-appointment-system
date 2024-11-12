<?php
// created by Simon MELIK-KAZARYAN

// Початок сесії
session_start();

// Перевірка, чи користувач авторизований
if (!isset($_SESSION['username'])) {
    // Якщо не авторизований, перенаправляємо на сторінку логіну
    header("Location: login.php");
    exit();
}

// Завантаження всіх записів
$appointments = json_decode(file_get_contents('data/appointments.json'), true);

// Оновлення статусу бронювання (якщо форма була надіслана)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['time'])) {
    $appointment_time = $_POST['time'];
    $patient_name = $_POST['patient_name'];
    $patient_phone = $_POST['patient_phone'];
    
    // Додавання нового запису
    $appointments[] = [
        'time' => $appointment_time,
        'status' => 'available',
        'patient_name' => '',
        'patient_phone' => ''
    ];

    // Перезаписуємо дані в JSON файл
    file_put_contents('data/appointments.json', json_encode($appointments, JSON_PRETTY_PRINT));
}

// Видалення запису, якщо отримано запит на видалення
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Видалення відповідного запису з масиву
    foreach ($appointments as $index => $appointment) {
        if ($appointment['time'] === $delete_id) {
            unset($appointments[$index]);
            break;
        }
    }
    
    // Перезаписуємо дані в JSON файл після видалення
    file_put_contents('data/appointments.json', json_encode(array_values($appointments), JSON_PRETTY_PRINT));
    
    // Перенаправляємо назад на адмін панель після видалення
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адмін-панель</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Адмін-панель: Управління записами</h2>
        <table>
            <thead>
                <tr>
                    <th>Час</th>
                    <th>Статус</th>
                    <th>Ім'я пацієнта</th>
                    <th>Телефон</th>
                    <th>Операції</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo $appointment['time']; ?></td>
                        <td><?php echo ucfirst($appointment['status']); ?></td>
                        <td>
                            <?php 
                                // Перевіряємо, чи є ім'я пацієнта
                                echo isset($appointment['patient_name']) && $appointment['status'] == 'booked' ? $appointment['patient_name'] : '-'; 
                            ?>
                        </td>
                        <td>
                            <?php 
                                // Перевіряємо, чи є телефон пацієнта
                                echo isset($appointment['patient_phone']) && $appointment['status'] == 'booked' ? $appointment['patient_phone'] : '-'; 
                            ?>
                        </td>
                        <td>
                            <!-- Кнопка видалення -->
                            <a href="admin.php?delete_id=<?php echo urlencode($appointment['time']); ?>" class="delete-btn" onclick="return confirm('Ви впевнені, що хочете видалити цей запис?');">Видалити</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Форма для додавання нового запису -->
        <h3 class="centered">Додати новий запис</h3>
        <form method="POST" action="admin.php">
            <label for="time">Час:</label>
            <input type="text" id="time" name="time" placeholder="Введіть час запису" required>

            <button type="submit">Додати запис</button>
        </form>

        <!-- Посилання на головну сторінку, стилізоване як кнопка -->
        <div class="back-to-home">
            <a href="index.php" class="back-btn">Повернутись на головну</a>
        </div>
    </div>
</body>
</html>
