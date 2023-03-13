<?php
	header ("Content-type: image/png");
	function encodeArr(&$arr){
		reset($arr);
		foreach ($arr as $key => $value){
			$arr[$key] = mb_convert_encoding($value." ", "UTF-8", "windows-1251, UTF-8");
			$arr[$key] = substr($arr[$key], 0, strlen($arr[$key]) - 1);
		}
	}
	require('../v-can_site/init.php');
	$vcan_site = new vcan_site();
	$vcan_site->onError = "ShowMessage";
	$vcan_site->onErrorData = "Ошибка каптчи";
	$captcha = $vcan_site->execute('exec=КэнСайтСервер.НоваяКаптча()');

	$caplen = strlen($captcha); // Длина текста
	$width = 120;
	$height = 40; // Ширина и высота картинки
	$font = dirname(__FILE__)."/comic.ttf"; // Шрифт текста
	$fontsize = 20; // Размер текста

	$im = imagecreatetruecolor($width, $height); // Создаёт новое изображение
	imagesavealpha($im, true); // Устанавливает прозрачность изображения
	$bg = imagecolorallocatealpha($im, 0, 0, 0, 127); // Идентификатор цвета для изображения
	imagefill($im, 0, 0, $bg); // Выполняет заливку цветом
  
	//putenv( 'GDFONTPATH=' . realpath('.') ); // Проверяет путь до файла со шрифтами

	$curcolor = imagecolorallocate($im, 0, 0, 0);// Цвет для букв
	for ($i = 0; $i < $caplen; $i++){
		$x = ($width - 20) / $caplen * $i + 10;// Растояние между символами
		$x = rand($x, $x+4);// Случайное смещение
		$y = $height - ( ($height - $fontsize) / 2 ); // Координата Y
		$angle = rand(-25, 25);// Случайный угол наклона 
		imagettftext($im, $fontsize, $angle, $x, $y, $curcolor, $font, $captcha[$i]); // Вывод текста
	}

	imagepng($im); // Выводим изображение
	imagedestroy($im);// Очищаем память
?>