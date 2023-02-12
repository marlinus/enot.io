<?php

require_once '../classes/Auth.php';
use classes\Auth;

session_start();

$auth = new Auth();
$auth->logout();
