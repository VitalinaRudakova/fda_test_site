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
$vcan_site->onErrorData = "Ошибка создания заказа";
encodeArr($_GET);
encodeArr($_POST);
echo($vcan_site->execute('exec=КэнСайтИнтерфейсДилера2.ОформитьЗаказ(ПараметрыЗапроса)'));
?>