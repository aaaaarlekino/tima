<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./styles.css" rel="stylesheet" />
    <link href="./login.css" rel="stylesheet" />
    <link rel="icon" href="./icon.ico" />
    <title>DubrovskiySTROY</title>
</head>
<body">
    <div class="menu">
        <div class="logo">
            <img src="logo.png" alt="logo" class="logo-img" />
        </div>
        <ul class="menu-buttons">
            <li class="menu-button"><a href="./index.html#main">Главная</a></li>
            <li class="menu-button"><a href="./index.html#about">О нас</a></li>
            <li class="menu-button"><a href="./index.html#offers">Услуги</a></li>
            <li class="menu-button"><a href="./index.html#feedback">Оформить заказ</a></li>
        </ul>
    </div>

    <div class="login-container">

        <?php
        include 'db.php';
        // Проверка, авторизован ли пользователь через куку
        if (isset($_COOKIE['user_hash'])) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE password = :password_hash");
            $stmt->bindParam(':password_hash', $_COOKIE['user_hash']);
            $stmt->execute();
            $user = $stmt->fetchAll();
            if ($user) {
                echo "<p style='color:black'>Вы уже авторизованы как " . htmlspecialchars($user['username']) . "</p>";
                exit;
            }
        }
        ?>


        <h2>Регистрация</h2>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Зарегистрироваться</button>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                include 'db.php';
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Хешируем пароль

                // Проверка уникальности пользователя
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
                $stmt->execute(['username' => $username, 'email' => $email]);
                $user = $stmt->fetch();

                if ($user) {
                    echo "<p style='color:red'>Username или Email уже зарегистрирован.<p>";
                } else {
                    // Вставка данных пользователя
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                    $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);

                    echo "<p style='color:green'>Регистрация прошла успешна. <a href='login.php' style='color:green'><i>Войти тут</i></a>.<p>";
                }
            }
            ?>
        </form>
    </div>

</html>