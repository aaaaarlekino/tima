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
    include 'tg.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $purchase = $_POST['purchase'];
        send_tg_message("Имя: ".$name."\nemail: ".$email."\nКомментарий: ".$purchase);
        
    }

    // Проверка, авторизован ли пользователь через куку
    if (isset($_COOKIE['user_hash'])) {
      $stmt = $conn->prepare("SELECT * FROM users WHERE password = :password_hash");
      $stmt->execute(['password_hash' => $_COOKIE['user_hash']]);
      $user = $stmt->fetch();
      $mail = $user[2];
      $name = $user[1];

      if ($user) {
        echo '<div class="order">
        <h3 style="margin-bottom: 20px;">Оформить заказ</h3>
        <form action="order.php" method="post">

          <label for="name">Ваше имя:</label>
          <br />
          <input type="text" id="name" name="name" value="'.$name.'"readonly/>
          <br />
          <label for="mail">Ваша почта:</label>
          <br />
          <input style="width: 100%;box-sizing: border-box;" name="email" type="email" id="mail" value="'.$mail.'"readonly/>
          <br />
          <label for="purchase">Опишите Ваши пожелания:</label>
          <br />
          <textarea style="width: 100%;box-sizing: border-box;" name="purchase" rows="10" required></textarea>
          <br />
          <input type="submit" value="Подтвердить заказ" class="submit-button" />
        </form>
        </div>';
        exit;
      }
    }
    
    ?>



  </div>
</html>


