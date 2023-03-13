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
	$vcan_site->onErrorData = "������ ������";
	$captcha = $vcan_site->execute('exec=UTF8SiteInterface.NewCaptcha()');
  $letters = 'ABCDEFGKIJKLMNOPQRSTUVWXYZ'; // �������

  $caplen = 5; //����� ������
  $caplen = strlen($captcha); //����� ������
  $width = 120; $height = 40; //������ � ������ ��������
  $font = 'comic.ttf';//����� ������
  $fontsize = 20;// ������ ������

  header('Content-type: image/png'); //��� ������������� ����������� (�������� � ������� PNG) 

  $im = imagecreatetruecolor($width, $height); //������� ����� �����������
  imagesavealpha($im, true); //������������� ������������ �����������
  $bg = imagecolorallocatealpha($im, 0, 0, 0, 127); //������������� ����� ��� �����������
  imagefill($im, 0, 0, $bg); //��������� ������� ������
  
  putenv( 'GDFONTPATH=' . realpath('.') ); //��������� ���� �� ����� �� ��������

  $curcolor = imagecolorallocate($im, 255, 255, 255);//���� ��� ������� �����
  for ($i = 0; $i < $caplen; $i++)
  {
    $x = ($width - 20) / $caplen * $i + 10;//��������� ����� ���������
    $x = rand($x, $x+4);//��������� ��������
    $y = $height - ( ($height - $fontsize) / 2 ); // ���������� Y
    /*$curcolor = imagecolorallocate( $im, rand(0, 100), rand(0, 100), rand(0, 100) );//���� ��� ������� �����*/
    $angle = rand(-25, 25);//��������� ���� ������� 
    imagettftext($im, $fontsize, $angle, $x, $y, $curcolor, $font, $captcha[$i]); //����� ������
  }

  imagepng($im); //������� �����������
  imagedestroy($im);//������� ������

?>