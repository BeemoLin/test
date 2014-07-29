<?php

if (!isset($_SESSION)) {
	session_start();
}
define('INPUT_DEBUG_MODE', true);
//define('INPUT_DEBUG_MODE', false);
//xdebug_disable();
xdebug_enable();

require_once('../define.php');
