<?php

namespace classes;

class Rate {

	/**
	 * Метод для получения всех валют из базы данных MySql
	 */

	public function getCurrency(): array {

		$conn = new \mysqli('localhost', 'root', 'root', 'auth', 3500);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		$sql = <<<SQL
		SELECT * FROM currency
		SQL;

		$result = $conn->query($sql);

		$temp = [];

		if ($result) {
			foreach ($result as $item) {
				$temp[] = $item;
			}
		}

		return $temp;
	}
}