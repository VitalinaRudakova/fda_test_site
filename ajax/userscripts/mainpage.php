<?
//require('../../v-can_site_connection.php');
require('../../v-can_site/init.php');
$vcan_site = new vcan_site();
$vcan_site->onError = "ShowMessage";
$vcan_site->onErrorData = "Ошибка загрузки главной страницы личного кабинета инициатора";
$vcan_site->encodeArr($_GET);
$vcan_site->encodeArr($_POST);
echo($vcan_site->execute('exec='.rawurlencode('ЛичныйКабинетИнициатораСайт.ФормаЛичногоКабинета(ПараметрыЗапроса)')));
?>