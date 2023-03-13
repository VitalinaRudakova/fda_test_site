<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="index, follow" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />	
		<link rel="shortcut icon" type="image/x-icon" href="assets/images/userpics/favicon.png">
		<title>Личный кабинет инициатора для 1С:ITIL</title>
	</head>
	<body>
	<?
		require("v-can_site_connection.php");
		$vcan_site->onError = "ShowMessage";
		$vcan_site->onErrorData = "Идет обновление программного обеспечения...";
	?>
		<div id="authForm" style="padding: 5px;"><br><center>Подключение к БД<br><img src='assets/images/ajax-loader.gif'></center></div>
		<div id="mainpage"></div>
		<script type="text/javascript" src="v-can_site.js?vcanversion=1602012087"></script>
		<script type="text/javascript" src="v-can_voice.js?vcanversion=1602012087"></script>
		<link rel="stylesheet" type="text/css" href="v-can_site.css?vcanversion=1602012087">
		<link rel="stylesheet" type="text/css" href="auth.css?vcanversion=1602012087">
		<link rel="stylesheet" type="text/css" href="itil_ipc.css?vcanversion=1602012087">
		<script type="text/javascript" src="itil_ipc.js?vcanversion=1602012087"></script>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css?vcanversion=1602012087">
		<script type="text/javascript" src="nicedit.js?vcanversion=1602012087"></script>
		<link rel="stylesheet" type="text/css" href="xcal.css?vcanversion=1602012087" />
		<script type="text/javascript" src="xcal.js?vcanversion=1602012087"></script> 
		<link rel="stylesheet" type="text/css" href="glider.css?vcanversion=1602012087" />
		<script type="text/javascript" src="glider.js?vcanversion=1602012087"></script> 
		<link rel="stylesheet" type="text/css" href="font-awesome.css?vcanversion=1602012087">
		<script type="text/javascript" src="lightbox/js/prototype.js?vcanversion=1602012087"></script>
		<script type="text/javascript" src="lightbox/js/scriptaculous.js?vcanversion=1602012087"></script>
		<script type="text/javascript" src="lightbox/js/lightbox.js?vcanversion=1602012087"></script>
		<link rel="stylesheet" href="lightbox/css/lightbox.css?vcanversion=1602012087" type="text/css" media="screen"/>
		<script language='javascript'>		
			var ГлобальныйКонтекст = new ГлобальныйКонтекстВебКлиента({
				ИдентификаторСайта: "v-can.site_itil_web",
				ИспользуетсяВИнтрасети: Ложь
			});
			ЗагрузитьСодержимоеЗапросомHttp('ajax/auth.php', '', 'authForm', true, {'ПриЗагрузке':'authOnLogin()'});
		</script>
	</body>
</html>