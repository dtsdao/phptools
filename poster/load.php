<?php
//Poster
//By DTSDAO

//PageName:Poster - Load
//CreateTime:2017.1.19

//HTML文件头
echo "<!DOCTYPE html>";

echo "\n<html>";
echo "\n<head>";
echo "\n\t<meta charset=utf-8>";
echo "\n</head>";

echo "\n";

//数据库（需要有一张表包含code,date,times）
$dbConf = array(
	'host' => '127.0.0.1',
	'user' => '',
	'pwd' => '',
	'db' => 'temp',
	'tb' => 'poster',
	'port' => 3306
);

@$conn = new mysqli($dbConf['host'],$dbConf['user'],$dbConf['pwd'],$dbConf['db'],$dbConf['port']);

//检查错误
if (mysqli_connect_errno()){
	echo "<title>CONNECT_ERROR</title>\n";
	echo "<div align=center>" . mysqli_connect_errno($conn) . " " . mysqli_connect_error($conn) . "</div>";
	exit;
} 

if ($_POST['code']){
	if (is_nan($_POST['date'])) exit;
	$timestamp = time() + $_POST['date'] * 3600 * 24;
	$sql = $conn->query("insert into " . $dbConf['tb'] . " values('" . $_POST['code'] . "'," . $timestamp . "," . $_POST['times'] . ")");
	if ((!$sql) || ($conn->affected_rows < 1)) echo "创建失败，错误：" . mysqli_errno($conn) . " " . mysqli_error($conn);
	
	$file = fopen($_POST['code'] . ".txt",'w');
	if (!$file) {
		echo "文件无法打开或无法创建！文件位置" . $_POST['code'] . ".txt";
		exit;
	}
	fwrite($file,htmlspecialchars($_POST['text']));
	fclose($file);
	
	echo "创建成功";
}

if ($_GET['code']){
	$sql = $conn->query("select * from " . $dbConf['tb'] . " where code='" . $_GET['code'] . "'");
	
	if ($sql->num_rows == 1) {
		$result = $sql->fetch_assoc();
		if (($result['times'] > 0) || ($result['times'] == -1)){
			if ($result['times'] > 0) {
				$newTimes = $result['times'] - 1;
				$conn->query("update "  . $dbConf['tb'] . " set times = '" . $newTimes . "' where code='" . $_GET['code'] . "'");
			}
			if ($result['date'] - time() >= 0) {
				if (file_exists($_GET['code'] . ".txt")) echo file_get_contents($_GET['code'] . ".txt"); else echo "页面不存在";
			} else {
				echo "超时";
				$conn->query("delete from " . $dbConf['tb'] . " where code='" . $_GET['code'] . "'");
			}
		} else {
			echo "超过规定次数";
			$conn->query("delete from " . $dbConf['tb'] . " where code='" . $_GET['code'] . "'");
		}
	} else echo "页面不存在";
	
	if (mysqli_errno($conn)){
			echo "<div align=center>" . mysqli_errno($conn) . " " . mysqli_error($conn) . "</div>";
			exit;
	}
}

$conn->close();
?>