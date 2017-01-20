<?php
//Poster
//By DTSDAO

//PageName:Poster
//Include:poster/
//CreateTime:2017.1.19

//DATABASE_SET in poster/load.php!!!

//获取预设密码
require_once 'password.php';
if (!$password || !file_exists('password.php')) header("Location: info.php");

session_start();

//HTML文件头
echo "<!DOCTYPE html>";

echo "\n<html>";
echo "\n<head>";
echo "\n\t<meta charset=utf-8>";
echo "\n</head>";

echo "\n<body>";
echo "\n<!-- Last Edit : " . date('g:i a, j M Y',getlastmod()+28800) . " -->";
echo "\n";

//登录
if ($_POST['password']){
	if ($_POST['password'] == $password) $_SESSION['login'] = true;
	else $_SESSION['login'] = false;
}

if ($_SESSION['login'] !== true) {
	echo "\n<form action=poster.php method=post>";
	echo "\n\tPassword:<input type=textbox name='password'>";
	if ($_SESSION['login'] === false) echo '<font color=red>密码错误</font>';
	if ($_SESSION['login'] !== true) echo "\n<input type=submit value='登录'>";
	echo "\n</form>";
	exit;
}
?>
<form action="poster/load.php" method="POST">
	新建临时授权页：<br />
	授权码（唯一）：<input name="code" value="<?php echo md5(time()); ?>" onclick="this.select()"><br />
	有效期：<input name="date" value="1">天<br />
	供使用次数（-1为无限制）：<input name="times" value="1"><br />
	文本信息:<br />
	<textarea name="text"></textarea><br />
	<input type="submit" value="提交">
</form>
</body>
</html>