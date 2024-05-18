<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE login='$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: claims.php");
        } else {
            echo "Неверный логин или пароль.";
        }
    } else {
        echo "Неверный логин или пароль.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Авторизация</h1>
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
        <form action="login.php" method="post">
                <label for="login">Логин</label>
                <input type="text" id="login" name="login" required>
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
                <button type="submit">Войти</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Нарушениям.Нет</p>
    </footer>
</body>
</html>
