<?

	function encodeArr(&$arr){
		reset($arr);
		foreach ($arr as $key => $value){
			$arr[$key] = mb_convert_encoding($value." ", "UTF-8", "windows-1251, UTF-8");
			$arr[$key] = substr($arr[$key], 0, strlen($arr[$key]) - 1);
		}
	}
  require('../../v-can_site_connection.php');
	$vcan_site->onError = "ShowMessage";
	$vcan_site->onErrorData = "Ошибка каптчи";
	$captcha = $vcan_site->execute('exec=UTF8SiteInterface.NewCaptcha()');
  $letters = 'ABCDEFGKIJKLMNOPQRSTUVWXYZ'; // алфавит

  $caplen = 5; //длина текста
  $caplen = strlen($captcha); //длина текста
  $width = 120; $height = 40; //ширина и высота картинки
  $font = 'comic.ttf';//шрифт текста
  $fontsize = 20;// размер текста

  header('Content-type: image/png'); //тип возвращаемого содержимого (картинка в формате PNG) 

  $im = imagecreatetruecolor($width, $height); //создаёт новое изображение
  imagesavealpha($im, true); //устанавливает прозрачность изображения
  $bg = imagecolorallocatealpha($im, 0, 0, 0, 127); //идентификатор цвета для изображения
  imagefill($im, 0, 0, $bg); //выполняет заливку цветом
  
  putenv( 'GDFONTPATH=' . realpath('.') ); //проверяет путь до файла со шрифтами

  $curcolor = imagecolorallocate($im, 255, 255, 255);//цвет для текущей буквы
  for ($i = 0; $i < $caplen; $i++)
  {
    $x = ($width - 20) / $caplen * $i + 10;//растояние между символами
    $x = rand($x, $x+4);//случайное смещение
    $y = $height - ( ($height - $fontsize) / 2 ); // координата Y
    /*$curcolor = imagecolorallocate( $im, rand(0, 100), rand(0, 100), rand(0, 100) );//цвет для текущей буквы*/
    $angle = rand(-25, 25);//случайный угол наклона 
    imagettftext($im, $fontsize, $angle, $x, $y, $curcolor, $font, $captcha[$i]); //вывод текста
  }

  imagepng($im); //выводим изображение
  imagedestroy($im);//очищаем память

?>