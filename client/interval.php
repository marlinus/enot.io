<?php

require_once './classes/Parser.php';
use classes\Parser;

	$interval = 10800; // 3 часа
	$file = __DIR__ . './logs/cron_time.tmp';

	if (!is_file($file)) {
		file_put_contents($file, time());
	} else {
		$last = file_get_contents($file);
		if ((int)$last + $interval < time()) {
			file_put_contents($file, time());

			$parser = new Parser();
			$parser->curlRequest();

		}
	}

