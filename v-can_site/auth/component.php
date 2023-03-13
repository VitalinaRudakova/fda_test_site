<?
	// Инициализация переменных для передачи параметров в 1С
	$vcanLogin				= ''; // Логин
	$vcanPassword			= ''; // Пароль
	$vcanPasswordConfirm	= ''; // Подтверждение пароля
	$vcanLogout				= ''; // Флаг действия "Выйти из аккаунта"
	$vcanSessionID			= ''; // Идентификатор сессии
	$new_vcanSessionID		= ''; // Новый идентификатор сессии
	//$additionalParams	= 	''; // Дополнительные произвольные параметры

	// Попробуем взять идентификатор сеанса из cookie
	if (isset($_COOKIE['vcanSessionID'])){
		$vcanSessionID = $_COOKIE['vcanSessionID'];
	}else{
		// Идентификатора сеанса в куках нет - предполагаем, что посетитель зашел на сайт впервые.
		// Уведомим 1С об этом.
		$additionalParams = $additionalParams.'&no_vcanSessionIDInCookies=true';
	}

	// Если пользователь только что залогинился, то его логин и пароль должны храниться в $_POST или $_GET
	if (isset($_POST['vcan_login']))			$vcanLogin				= $_POST['vcan_login'];
	if (isset($_POST['vcan_password']))			$vcanPassword			= $_POST['vcan_password'];
	if (isset($_POST['vcan_passwordconfirm']))	$vcanPasswordConfirm	= $_POST['vcan_passwordconfirm'];
	if (isset($_POST['vcan_logout']))			$vcanLogout				= $_POST['vcan_logout'];
	if (isset($_GET['vcan_login']))				$vcanLogin				= $_GET['vcan_login'];
	if (isset($_GET['vcan_password']))			$vcanPassword			= $_GET['vcan_password'];
	if (isset($_GET['vcan_passwordconfirm']))	$vcanPasswordConfirm	= $_GET['vcan_passwordconfirm'];
	if (isset($_GET['vcan_logout']))			$vcanLogout				= $_GET['vcan_logout'];

	// Хеширование пароля
	if(!empty($vcanPassword)){
		if($this->encryptPass === "MD5"){
			$vcanPassword = md5($vcanPassword);
			$vcanPasswordConfirm = md5($vcanPasswordConfirm);
		}
		if($this->encryptPass === "SHA1"){
			$vcanPassword = sha1($vcanPassword);
			$vcanPasswordConfirm = sha1($vcanPasswordConfirm);
		}
		if($this->encryptPass === "SHA256"){
			$vcanPassword = hash('sha256', $vcanPassword);
			$vcanPasswordConfirm = hash('sha256', $vcanPasswordConfirm);
		}
	}
	
	// Вызов 1С
	$authFormSource = $this->site('exec=auth&vcan_login='.$vcanLogin.'&vcan_password='.$vcanPassword.'&vcan_passwordconfirm='.$vcanPasswordConfirm.'&vcan_logout='.$vcanLogout.'&vcan_sessionid='.$vcanSessionID.$additionalParams);

	// Извлечем из кода формы аутентификации идентификатор сеанса
	if(preg_match("~#vcan_sessionidStart#(.*)#vcan_sessionidEnd#~", $authFormSource, $preg)){
		$new_vcanSessionID = $preg[1];
	}else{
		$new_vcanSessionID = '';
	}
	// Сохранение идентификатора сеанса на 30 дней
	//setcookie("vcanSessionID", $new_vcanSessionID, time() + 24 * 60 * 60 * 30, '/', $_SERVER['HTTP_HOST']);
	// Повторная установка идентификатора сеанса на клиенте на случай, если на сервере куки уже установить нельзя
	echo('<script language="javascript">document.cookie = "vcanSessionID=' . $new_vcanSessionID . '; path=/; expires=' . date('d/m/Y H:i:s', time() + 24 * 60 * 60 * 30 ) . '"</script>');
	$this->sessionID = $new_vcanSessionID;
	
	// Удаление "обертки" для поиска идентификатора сеанса из текста формы аутентификации
	$authFormSource = str_replace('#vcan_sessionidStart#', '', $authFormSource);
	$authFormSource = str_replace('#vcan_sessionidEnd#',   '', $authFormSource);

	// Вывод формы аутентификации
	echo($authFormSource);
?>