<?php
//phpinfoi
//2016.1.12
ini_set('error_reporting',NULL);

session_start();

if (!file_exists("password.php")){
	if($_POST['set']){
		$file = fopen("password.php",'w');
		fwrite($file,"<?php \$password = '" . $_POST['set'] . "'; ?>");
		$_SESSION['login'] = true;
		fclose($file);
		header("Location: " . $_SERVER['PHP_SELF']);
	}else{
		echo '<form method="POST" action="info.php">';
		echo 'Set your password:<input type="password" name="set">';
		echo '</form>';	
	}
}else{
	include "password.php";
	
	if ($_POST['password'] == $password){
		$_SESSION['login'] = true;
		header("Location: " . $_SERVER['PHP_SELF']);
	}
	
	if ($_SESSION['login'] != true){
		echo '<form method="POST" action="info.php">';
		echo 'Password:<input type="password" name="password">';
		echo '</form>';	
	}
}

if ($_SESSION['login'] == true) phpinfo();
?>