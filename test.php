<?php
//Test
//2016.6.21

session_start();

//获取预设密码
require_once 'password.php';
if (!$password || !file_exists('password.php')) header("Location: info.php");

//登录
if ($_POST['password']){
	if ($_POST['password'] == $password) $_SESSION['login'] = true;
	else $_SESSION['login'] = false;
}

if (!$_POST["write"]) {
	if ($_SESSION['login'] === true){
		?>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
			<p>Script Here:</p>
			<p>< ?php</p>
			<textarea name="write"></textarea>
			<p>? ></p>
			<input type=submit value="Run">
		</form>
		<?php
	} else {
		?>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
			<input type=password name="password">
			<input type=submit value="登录">
		</form>
		<?php
	}

} else {
	if ($_SESSION['login'] != true) {
		echo "未登录！";
		exit;
	}
	$script = 
	'<?php ' . "\n" . 
	$_POST["write"] . "\n" . 
	'?>' . "\n" .
	'<a href="' . $_SERVER["PHP_SELF"] . '"><input type="submit" value="Return"></a>';
	$file = fopen("test-create.php",'w');
	if (!$file) {
		echo "文件无法打开或无法创建！文件位置：test-create.php";
		exit;
	}
	fwrite($file,$script);
	fclose($file);
	header('Location: test-create.php');
}
?>