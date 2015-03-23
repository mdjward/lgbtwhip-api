<?php

require_once __DIR__ . '/../lib/autoload.php';

// The root of the codebase
define('APPLICATION_PATH_ROOT', realpath(__DIR__ . '/../'));

// Include Phockito
require_once(APPLICATION_PATH_ROOT . '/lib/hafriedlander/phockito/Phockito_Globals.php');
Phockito::include_hamcrest();