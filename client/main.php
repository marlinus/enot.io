<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Main page</title>
  <link rel="stylesheet" href="./client/style/style.css">
</head>
<body>
<?php
  session_start();
  require_once __DIR__ . './interval.php';
  if (isset($_SESSION['auth']) && $_SESSION['auth']):
?>

<div class="wrapper">
  <div class="link">
    <a href="./client/logout.php">Выход</a>
  </div>
  <div class="link">
    <a href="./client/profile.php">Профиль: <?= $_SESSION['login'] ?? 'default' ?></a>
  </div>
</div>

<?php else: ?>

<div class="wrapper">
  <div class="link">
    <a href="./client/registration.php">Регистрация</a>
  </div>
  <div class="link">
    <a href="./client/login.php">Вход</a>
  </div>
</div>


<?php endif; ?>

</body>
</html>