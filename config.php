<?php 

	session_start();
	date_default_timezone_set("America/Sao_Paulo");
	
	$autoload = function($class) {
		include('class/'.$class.'.php');
	};
	spl_autoload_register($autoload);

	// define('INCLUDE_PATH','http://molian.com.br/olympo/');
	define('INCLUDE_PATH','http://localhost/olympo/');
	define('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']."/olympo");

	define('NOME_EMPRESA','Olympo Tournaments');
?>