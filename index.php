<?php

$uri = $_SERVER['REQUEST_URI'];

switch ($uri) {
	case '/': {
		include_once __DIR__ . '/client/main.php';
		break;
	}
}