<?php

  require_once '../classes/Rate.php';
  use classes\Rate;

  session_start();

  $rate = new Rate();
  $data = $rate->getCurrency();

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Профиль</title>
  <link rel="stylesheet" href="./style/calc.css">
</head>
<body>

	<h1>Личный кабинет пользователя <?= $_SESSION['login'] ?? 'Default' ?></h1>

  <div class="container">
    <div class="wrapper">
      <h2>Конвертер валют</h2>
      <form action="" method="post">
        <div class="currency">
          <label for="currency">Выберите валюту
            <select name="currency" id="currency">
		          <?php
                foreach ($data as $valute) {
                  echo "<option nominal=${valute['nominal']} value='${valute['value']}'>${valute['charcode']} - ${valute['name']}</option>";
                }
		          ?>
            </select>
          </label>
        </div>

        <div class="conversion">
          <label for="number-one">RUB
            <input class="active" type="number" name="left" id="number-one">
          </label>
          <label for="number-two"><span class="span-text">AUD</span>
            <input class="active" type="number" name="right" id="number-two">
          </label>
        </div>
      </form>
    </div>
  </div>

  <script>

    const select = document.querySelector('select');
    const labelRight = document.querySelector('label[for="number-two"]');

    let currentRate = '';
    let nominal = 1;

    const inputLeft = document.querySelector('input[name="left"]');
    const inputRight = document.querySelector('input[name="right"]');

    select.addEventListener('change', event => {
    	const option = event.target.selectedOptions[0];
			const rate = option.textContent;

			inputLeft.value = inputRight.value = '';

			labelRight.firstElementChild.textContent = rate.slice(0, 3);
			currentRate = +option.getAttribute('value');
			nominal = +option.getAttribute('nominal');
    });

    inputLeft.addEventListener('input', event => {
      const value = +event.target.value;
      inputRight.value = ((value / currentRate) * nominal).toFixed(2);
    });

		inputRight.addEventListener('input', event => {
			const value = +event.target.value;
			inputLeft.value = ((value * currentRate) / nominal).toFixed(2);
		});
  </script>
</body>
</html>