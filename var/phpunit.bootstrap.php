<?php

require_once __DIR__ . '/../vendor/autoload.php';

// The root of the codebase
define('APPLICATION_PATH_ROOT', realpath(__DIR__ . '/../'));

// Include Phockito
require_once(APPLICATION_PATH_ROOT . '/vendor/hafriedlander/phockito/Phockito_Globals.php');
Phockito::include_hamcrest();