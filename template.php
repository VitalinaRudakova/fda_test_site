<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "v-can");
$APPLICATION->SetPageProperty("description", "html-интерфейс личного кабинета инициатора для 1С:ITIL");
$APPLICATION->SetTitle("html-интерфейс личного кабинета инициатора для 1С:ITIL");
?>

<!--<h2>html-интерфейс личного кабинета инициатора для 1С:ITIL</h2><br/>-->
<br/><br/>
<h2>Личный кабинет инициатора</h2>
<br/><a href='index.php'>Исходный шаблон без применения стилей сайта</a><br/><br/>
Демо-доступ: логин - test, пароль - test</br></br>
<?
header("Content-Type: text/html; charset=windows-1251");
//require($_SERVER["DOCUMENT_ROOT"].'/v-can_site/init.php');
//$vcan_site = new vcan_site('init_params_ipc-itil.php');
require('v-can_site_connection.php');
$vcan_site->onError = "ShowMessage";
$vcan_site->onErrorData = "Идет обновление программного обеспечения...";
echo('<br/>');
?>
<div id="authForm"><center><img src='assets/images/ajax-loader.gif'></center></div>
<br/>
<div id="mainpage"></div>
<br/><br/>

<script type="text/javascript" src="v-can.site.js"></script>
<link rel="stylesheet" type="text/css" href="v-can.site.css">
<script type="text/javascript" src="itil.ipc.js"></script>
<link rel="stylesheet" type="text/css" href="http://digitcat.ru/bootstrap337/css/bootstrap.css">
<script language='javascript'>
	document.body.style.padding = '20px';
	showContent('ajax/auth.php', '', 'authForm', true, {'onLoad':'mainPageLoad()'});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>