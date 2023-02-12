<?php

namespace classes;

use JetBrains\PhpStorm\NoReturn;

class Auth {

	public function __construct() {

	}

	/**
	 * Метод для регистрации пользователя
	 */

	public function registration() {
		$login = $_POST['login'];
		$password = $_POST['password'];

		if ($login && $password) {
			$conn = new \mysqli('localhost', 'root', 'root', 'auth', 3500);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$password = password_hash($password, PASSWORD_DEFAULT);

			if (!$this->checkUserExists($conn, $login)) {
				$sql = <<<SQL
				INSERT INTO users (login, password) VALUE ('$login', '$password')
				SQL;

				if ($conn->query($sql)) {
					$_SESSION['auth'] = true;
					$_SESSION['login'] = $login;
					$this->close($conn);
					header('Location: /');
					die();
				} else{
					echo "Ошибка: " . $conn->error;
				}
			} else {
				echo 'Пользователь уже существует';
			}
		}
	}

	/**
	 * Метод для аутентификации пользователя по логину и паролю
	 */

	public function authentication() {
		$login = $_POST['login'];
		$password = $_POST['password'];

		if ($login && $password) {

			$conn = new \mysqli('localhost', 'root', 'root', 'auth', 3500);

			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}

			$sql = <<<SQL
			SELECT * FROM users WHERE login = '$login'
			SQL;

			$result = $conn->query($sql);
			$user = $result->fetch_assoc();

			if (!empty($user)) {
				$hash = $user['password'];

				if (password_verify($password, $hash)) {
					$this->close($conn);
					$this->authorization($user);
				} else {
					echo 'Пароль или логин не правильный';
				}
			} else {
				echo 'Такого пользователя не существует';
			}
		}
	}

	/**
	 * Метод для дальнейшей авторизации пользователя
	 */

	#[NoReturn] private function authorization($user) {
		$_SESSION['auth'] = true;
		$_SESSION['login'] = $user['login'];
		header('Location: /');
	}

	/**
	 * Метод для выхода из сессии пользователя
	 */

	public function logout() {
		$_SESSION['auth'] = null;
		$_SESSION['login'] = null;
		header('Location: /');
	}

	/**
	 * Метод для проверки существования пользователя в базе данных
	 */

	private function checkUserExists(\mysqli $conn, $login): bool {

		$sql = <<<SQL
		SELECT * FROM users WHERE login = '$login'
		SQL;

		return $conn->query($sql)->num_rows > 0;
	}

	/**
	 * Метод для закрытия открытого соединения с базой данных
	 */

	private function close( \mysqli $conn) {
		$conn->close();
	}
}