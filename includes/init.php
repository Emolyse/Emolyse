<?php 
	error_reporting(E_ALL);
	
	if (!isset($_SESSION)) {
		session_start();
	}
	
	define ('RACINE_SITE',realpath(dirname(__FILE__)).'/');
	define ('RACINE_WEB',substr($_SERVER['SCRIPT_NAME'],0,
		strpos($_SERVER['SCRIPT_NAME'],substr($_SERVER['SCRIPT_FILENAME'],
		strlen(RACINE_SITE)))));

	define ('SESSION_ADMIN','SESSION_ADMIN');

?>