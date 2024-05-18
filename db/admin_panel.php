<?php
include 'db.php';
session_start();

// Проверка логина и пароля администратора
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login']) && isset($_POST['password'])) {
    if ($_POST['login'] === 'kuro' && $_POST['password'] === '123') {
        $_SESSION['admin_logged_in'] = true;
    } else {
        header("Location: admin_login.php");
        exit();
    }
}

// Проверка сессии администратора
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Обновление статуса заявки
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $claim_id = $_POST['claim_id'];
    $new_status = $_POST['status'];
    $update_sql = "UPDATE claims SET status='$new_status' WHERE id='$claim_id'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Ошибка: " . $update_sql . "<br>" . $conn->error;
    }
}

// Получение списка заявок
$sql = "SELECT claims.id, users.fio, claims.car_number, claims.description, claims.status FROM claims JOIN users ON claims.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Панель администратора</h1>
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
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Номер автомобиля</th>
                    <th>Описание</th>
                    <th>Статус</th>
                    <th style="width: 200px;">Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['fio']; ?></td>
                    <td><?php echo $row['car_number']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <form action="admin_panel.php" method="post">
                            <input type="hidden" name="claim_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="новое" <?php echo $row['status'] == 'новое' ? 'selected' : ''; ?>>Новое</option>
                                <option value="подтверждено" <?php echo $row['status'] == 'подтверждено' ? 'selected' : ''; ?>>Подтверждено</option>
                                <option value="отклонено" <?php echo $row['status'] == 'отклонено' ? 'selected' : ''; ?>>Отклонено</option>
                            </select>
                            <button type="submit" name="update_status">Обновить</button>
                        </form>
                    </td>
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
