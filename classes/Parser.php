<?php

namespace classes;

class Parser {

	private string $url;

	public function __construct() {
		$this->url = 'https://www.cbr-xml-daily.ru/daily_json.js';
	}

	/**
	 * Метод для осуществления запроса на сайт с валютами в формате JSON
	 */

	public function curlRequest() {

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $this->url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_PROXY_SSL_VERIFYHOST, false);

		$result = curl_exec($curl);

		$data = json_decode($result, true);

		$this->mappingData($data);
	}

	/**
	 * Метод для преобразования полученных данных JSON
	 */

	private function mappingData($data) {
		$data = array_map(function ($item) {
			return [
				'charcode' => $item['CharCode'],
				'nominal' => $item['Nominal'],
				'name' => $item['Name'],
				'value' => (float) $item['Value'],
				'previous-value' => (float) $item['Previous']
			];
		}, $data['Valute']);

		$this->putIntoDB($data);
	}

	/**
	 * Метод для сохранения данных валют в базу MySql
	 */

	private function putIntoDB($data) {
		$conn = new \mysqli('localhost', 'root', 'root', 'auth', 3500);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		foreach ($data as $item) {
			$sql = "INSERT INTO currency (charcode, nominal, name, value, previousvalue) 
		VALUE ('${item['charcode']}', '${item['nominal']}', '${item['name']}', '${item['value']}', '${item['previous-value']}')";

			if (!$conn->query($sql)) {
				echo 'Ошибка: ' . $conn->error;
			}
		}
	}
}