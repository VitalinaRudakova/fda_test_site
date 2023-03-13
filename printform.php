<!doctype html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="robots" content="index, follow" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link rel="stylesheet" href="auth.css">
    <title>Личный кабинет</title>
</head>

<body>

<?
	require($_SERVER["DOCUMENT_ROOT"]."/v-can_site/init.php");
	$vcan_site = new vcan_site("init_params_psg.php");
	$vcan_site->onError = "ShowMessage";
	$vcan_site->onErrorData = "Идет обновление программного обеспечения...";
?>
<div id="authForm" style="display: none;"><center>Подключение к БД<br/><img src='assets/images/ajax-loader.gif'></center></div>
<div id="mainpage" style="margin: 0px 20px"><center><br/><br/>Документ формируется...<br/><img src='assets/images/ajax-loader.gif'></center></div>

<script type="text/javascript" src="printform.js?vcanversion=1602012087"></script>
<script type="text/javascript" src="v-can_site.js?vcanversion=1602012087"></script>
<script type="text/javascript" src="v-can_site_connection.js?vcanversion=1602012087"></script>
<link rel="stylesheet" type="text/css" href="v-can_site.css?vcanversion=1602012087">
<script type="text/javascript" src="itil_ipc.js?vcanversion=1602012087"></script>
<link rel="stylesheet" type="text/css" href="itil_ipc.css?vcanversion=1602012087">
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css?vcanversion=1602012087">
<script language='javascript'>
	ЗагрузитьСодержимоеЗапросомHttp('ajax/auth.php', '', 'authForm', true, {'ПриЗагрузке':'printformPageLoad()'});
</script>

</body>
</html>