<?php
// created by Simon MELIK-KAZARYAN

$bookings = json_decode(file_get_contents('data/bookings.json'), true);
$time = $_GET['time'] ?? '';

// Перевіряємо, чи обраний слот доступний
$selectedSlot = null;
foreach ($bookings as &$slot) {
    if ($slot['time'] === $time && $slot['status'] == 'available') {
        $selectedSlot = &$slot;
        break;
    }
}

// Якщо слот недоступний, перенаправляємо
if ($selectedSlot === null) {
    header('Location: index.php');
    exit;
}

// Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    if ($name) {
        $selectedSlot['status'] = 'booked';
        $selectedSlot['name'] = $name;
        file_put_contents('data/bookings.json', json_encode($bookings, JSON_PRETTY_PRINT));
        echo "<p>Бронювання підтверджено для $name!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бронювання</title>
</head>
<body>
    <h1>Бронювання на <?php echo $time; ?></h1>
    <form method="POST">
        <label for="name">Ваше ім'я:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Підтвердити бронювання</button>
    </form>
    <a href="index.php">Назад до доступних слотів</a>
</body>
</html>
