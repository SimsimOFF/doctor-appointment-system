<?php
// created by Simon MELIK-KAZARYAN

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Облікові дані для адміністратора
    $admin_username = "admin";
    $admin_password = "password"; // Вкажіть свій пароль

    // Перевірка даних
    if ($_POST['username'] == $admin_username && $_POST['password'] == $admin_password) {
        $_SESSION['username'] = $admin_username;
        header("Location: admin.php"); // Перенаправлення на адмін панель
        exit();
    } else {
        $error_message = "Невірне ім'я користувача або пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід до адмін-панелі</title>
    <link rel="stylesheet" href="style.css"> <!-- Підключення CSS -->
</head>
<body>

<div class="form-container">
    <form method="POST" action="login.php">
        <h2>Вхід до адмін-панелі</h2>
        <label for="username">Ім'я користувача</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Пароль</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Увійти</button>

        <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
    </form>
</div>

</body>
</html>
