<!DOCTYPE html>
<!-- created by Simon MELIK-KAZARYAN -->

<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запис на прийом до лікаря</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Онлайн запис на прийом до лікаря</h1>
        <h2>Доступні слоти:</h2>
        <ul id="slots">
            <?php
            $appointments = json_decode(file_get_contents('data/appointments.json'), true);
            foreach ($appointments as $appointment):
            ?>
                <li>
                    <strong><?php echo $appointment['time']; ?></strong> - 
                    <?php echo $appointment['status'] == 'available' ? 'Доступно' : 'Зайнято'; ?>
                    <?php if ($appointment['status'] == 'available'): ?>
                        <a href="appointment.php?time=<?php echo $appointment['time']; ?>">Записатися</a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Кнопка для переходу до адмін-панелі -->
        <form action="login.php" method="get">
            <button type="submit">Перейти до адмін-панелі</button>
        </form>
    </div>
</body>
</html>
