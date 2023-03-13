<!--
(с) Юрий Лазаренко, Севастополь
e-mail lazarenkoyv@mail.ru
v-can.Site
v 6.2.2.3
12.10.2021
-->
<!doctype html>
<html lang="zxx">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="robots" content="noindex, nofollow" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<title>Модификация скриптов для обновления js в кэше</title>
	</head>
	<body>
		<h3>Модификация скриптов для обновления js в кэше</h3>
		<?php
			if(isset($_GET['modify']) && $_GET['modify'] === "true"){
				$version = "".round(microtime(true));
				$versiontag = "?vcanversion=";
				echo("Новая версия скриптов:".$version."<br>");
				echo("Обработанные скрипты:<br>");
				$path = __DIR__;
				$files = glob_tree_search($path, '*.{php,html}');
				foreach($files as $filepath){
					if($filepath !== "jscache.php"){
						if(strpos(file_get_contents($filepath), $versiontag) !== false){
							$file = file($filepath);
							if(is_array($file)){
								foreach($file as $key => $value){
									if(strpos($value, $versiontag) !== false){
										$srposition = strpos($value, $versiontag) + strlen($versiontag);
										$file[$key] = substr_replace($value, $version, $srposition, strlen($version));
									}
								}
							}else{
								exit ("Ошибка");
							}
							$fp = fopen($filepath, "w+");
							fwrite($fp, implode("", $file));
							fclose($fp);
							echo($filepath."<br>");
						}
					}
				}
			}else{
				echo("Не указан ключ модификации");
			}
			function glob_tree_search($path, $pattern, $_base_path = null){
				if (is_null($_base_path)) {
					$_base_path = '';
				} else {
					$_base_path .= basename($path) . '/';
				}
			 
				$out = array();
				foreach(glob($path . '/' . $pattern, GLOB_BRACE) as $file) {
					$out[] = $_base_path . basename($file);
				}
				
				foreach(glob($path . '/*', GLOB_ONLYDIR) as $file) {
					$out = array_merge($out, glob_tree_search($file, $pattern, $_base_path));
				}
			 
				return $out;
			}
		?>
	</body>
</html>