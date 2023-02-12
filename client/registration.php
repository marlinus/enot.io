<?php

require_once '../classes/Auth.php';
use classes\Auth;

session_start();
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Registration</title>
  <link rel="stylesheet" href="./style/style.css">
</head>
<body>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET'):
	if (isset($_SESSION['auth']) && $_SESSION['auth']) {
		header('Location: ./main.php');
		die();
	}
?>

<div class="wrapper">
  <form action="" method="post">
    <label for="login">Введите логин</label>
    <input class="active-input" type="text" placeholder="Example: tukan23" name="login" id="login"><br>
    <label for="password">Введите пароль</label>
    <input class="active-input" type="password" name="password" id="password"><br>
    <input class="active-submit" type="submit" value="Зарегистрироваться">
  </form>
</div>

<?php elseif($_SERVER['REQUEST_METHOD'] === 'POST'):

	$auth = new Auth();
	$auth->registration();

endif; ?>

</body>
</html>
