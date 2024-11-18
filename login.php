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

<body>
  <script>
    // Функция для удаления cookie
    function deleteCookie() {
      // Устанавливаем срок действия на прошедшую дату, чтобы удалить cookie
      document.cookie = 'user_hash' + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      location.reload();
    }
    function makeOrder() {
      location.href='./order.php'
    }


  </script>

  <div class="menu">
    <div class="logo">
      <img src="logo.png" alt="logo" class="logo-img" />
    </div>
    <ul class="menu-buttons">
      <li class="menu-button"><a href="./index.html#main">Главная</a></li>
      <li class="menu-button"><a href="./index.html#about">О нас</a></li>
      <li class="menu-button"><a href="./index.html#offers">Услуги</a></li>
    </ul>
  </div>

  <div class="login-container">
    <?php
    include 'db.php';

    // Проверка, авторизован ли пользователь через куку
    if (isset($_COOKIE['user_hash'])) {
      $stmt = $conn->prepare("SELECT * FROM users WHERE password = :password_hash");
      $stmt->execute(['password_hash' => $_COOKIE['user_hash']]);
      $user = $stmt->fetch();

      if ($user) {
        echo "<p style='color:black;margin-bottom: 10px;'>Добрый день, " . htmlspecialchars($user['username']) . "!</p>";
        echo "<button onclick='makeOrder()' style='margin-bottom: 10px;'>Сделать заказ</button>";
        echo "<button onclick='deleteCookie()'>Выйти</button>";
        exit;
      }
    }
    ?>
    <h2>Вход</h2>
    <form action="login.php" method="post">
      <input type="text" name="username" placeholder="Логин" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include 'db.php';
        // Подключение к базе данных
        $username = $_POST['username'];
        $password = $_POST['password'];
        // Проверка данных пользователя
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
          // Устанавливаем куку с логином пользователя (длительность — 1 неделя)
          setcookie("user_hash", $user['password'], time() + (7 * 24 * 60 * 60), "/"); // Кука на 7 дней
          header("Refresh:0");
        } else {
          echo "<p style='color:red'>Неправильный username или password.</p>";
          }
        }
      ?>
      <button type="submit">Войти</button>
    </form>
    <a class="register-link" href="register.php">Нет аккаунта? Зарегистрируйтесь</a>
  </div>
</html>


