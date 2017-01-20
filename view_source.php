<?php
//Source Viewer
//By DTSDAO

//PageName:Source Viewer
//CreateTime:2016.3.18

ini_set('error_reporting',NULL);
$set_folder = "./";

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

//设置目录
{
	//根据传送目录设置根目录
	if ($_POST['folder']){
		$folder = $_SESSION['folder'] . $_POST['folder'] . '/';
	} else {
		$folder = $_SESSION['folder'];
	}

	//判断是否为真正文件夹
	if (strpos($folder,'../') !== false || !is_dir($folder)){
		$folder_wrong = '不允许访问或不存在的文件夹';
		$folder = $_SESSION['folder'];
	}

	//预设目录
	if ($_SESSION['folder'] == NULL) $folder = $set_folder;

	//写入Session
	$_SESSION['folder'] = $folder;

	if ($_POST['reset_folder'] == '回到根目录') {
		$_SESSION['folder'] = $set_folder;
	}
}


//显示源代码
if ($_POST['file']){
	if ($_SESSION['login']){
		if (!show_source($_SESSION['folder'] . $_POST['file'])) $file_wrong = '文件不存在';
		$show_closefile = true;
	} else $file_wrong = '未登录';
}

//输出文件目录
if ($_SESSION['login']){
	if (!$_POST['file'] || $file_wrong){
		echo "\n<p>Here is " . $_SESSION['folder'] . "</p>";
		$dir = opendir($_SESSION['folder']);
		
		while (false !== ($file = readdir($dir))){
			if (is_dir($_SESSION['folder'] . $file)) $coloring="#0000BB"; else $coloring="#DD0000";
			if ($file != "." && $file != "..") echo "\n<li style='color:" . $coloring . "'>" . $file . "</li>";
		}
		
		closedir($dir);
	}
} else $folder_wrong = '未登录';


//表单 开始
echo "\n<form action=view_source.php method=post>";

if ($_SESSION['login'] === true) {
	//文件名及目录输入
	echo "\n\tFilename:<input type=textbox name='file'>";
		if ($file_wrong) echo '<font color=red>' . $file_wrong . '</font>';
	echo "\n\t<br />";

	echo "\n\tFolder:<input type=textbox name='folder'>/";
			if ($folder_wrong) echo '<font color=red>' . $folder_wrong . '</font>';
	echo "\n\t<br />";
} else {
	echo "\n\tPassword:<input type=textbox name='password'>";
	if ($_SESSION['login'] === false) $login_wrong = '密码错误</font>';
		if ($login_wrong) echo '<font color=red>' . $login_wrong . '</font>';
}

echo "\n<br />";

if ($_SESSION['login'] === true) $button_value = "查询"; else $button_value = "登录";
	echo "\n<input type=submit value='" . $button_value . "'>";
		echo "\n\t<input type=submit name='reset_folder' value='回到根目录'>";
		if ($show_closefile && !$file_wrong) echo "\n\t<input type=submit value='关闭文件'>";

//表单 结束
echo "\n</form>";
echo "\n</body>";
echo "\n</html>";

//Version Release 1.0

//Update logs
/* 
	3.25 Finish the main program.
	3.29 Fix some serious problems.
		 Speed up.
		 Make the UI better.
		 Add "Close file" button.
	4.2 Fix a serious problem.
*/
?>