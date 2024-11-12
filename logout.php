<?php
// created by Simon MELIK-KAZARYAN

session_start();
session_unset(); // Видаляє всі змінні сесії
session_destroy(); // Завершує сесію
header('Location: index.php'); // Переходить на головну сторінку
exit;
