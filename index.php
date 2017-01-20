<?php
//Index
//2016.3.19

$tools = array(
	'PHPinfo' => 'info.php',
	'Source Viewer' => 'view_source.php',
	'Test Source' => 'test.php'
);
$projects = array(
	'SMM' => 'smm/',
	'DPM' => 'dpm/',
	'Blog' => 'blog/',
	'Sayings By Teachers From Class Eight' => 'sbtfce/',
	'New DPM' => 'ndpm/'
);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<title>Index - DTSDAO's local website</title>
</head>

<body>
	<h1 align="center">DTSDAO's local website</h1>

	<br />

	<div align=center>
		工具:
		<?php
		if (sizeof($tools) > 0){
			foreach ($tools as $name => $url){
				echo "\n\t<a href='" . $url . "'>" . $name . "</a>";
			}
		} else echo '无';
		?>

	</div>

	<br />

	<div align=center>
		项目:
		<?php
		if (sizeof($projects) > 0){
			foreach ($projects as $name => $url){
				echo "\n\t<a href='" . $url . "'>" . $name . "</a>";
			}
		} else echo '无';
		?>

	</div>

	<br />

	<p align="center">DTSDAO &copy; <?php echo date('Y'); ?></p>
</body>
</html>
