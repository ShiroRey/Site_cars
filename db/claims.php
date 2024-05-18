<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM claims WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявления</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Мои заявления</h1>
        <nav>
            <ul>
                <li><a href="index.php">Главная</a></li>
                <li><a href="login.php">Авторизация</a></li>
                <li><a href="register.php">Регистрация</a></li>
                <li><a href="admin_login.php">Админ панель</a></li>
                <hr>
                <li><a href="new_claim.php">Оставить новое заявление</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Номер автомобиля</th>
                        <th>Описание</th>
                        <th>Статус</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['car_number']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Нарушениям.Нет</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
