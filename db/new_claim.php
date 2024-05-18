<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $car_number = $_POST['car_number'];
    $description = $_POST['description'];

    $sql = "INSERT INTO claims (user_id, car_number, description, status) VALUES ('$user_id', '$car_number', '$description', 'новое')";

    if ($conn->query($sql) === TRUE) {
        header("Location: claims.php");
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новое заявление</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Новое заявление</h1>
        <nav>
            <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="login.php">Авторизация</a></li>
                <li><a href="register.php">Регистрация</a></li>
                <li><a href="admin_login.php">Админ панель</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="new_claim.php" method="post">
            <label for="car_number">Номер автомобиля</label>
            <input type="text" id="car_number" name="car_number" required>
            <label for="description">Описание нарушения</label>
            <textarea id="description" name="description" required></textarea>
            <button type="submit">Отправить заявление</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Нарушениям.Нет</p>
    </footer>
</body>
</html>
