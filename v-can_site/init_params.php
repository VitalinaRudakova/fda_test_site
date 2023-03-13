<?
	// НАСТРОЙКИ МОДУЛЯ

	// * URL базы 1С, обязателен к заполнению
	$this->base1CURL	= 'http://<server>/<base>/hs/';

	// Идентификатор сайта
	require_once 'Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if ($detect->isMobile() || $detect->isTablet()) {
		 $this->siteID		= 'v-can.site_mobile';
	}else{
		$this->siteID		= 'v-can.site';
	}

	// Кодировка сайта. Если совпадает с кодировкой 1С, то параметр можно оставить пустым
	$this->siteCodepage	= 'UTF-8';

	// Кодировка 1C. Если совпадает с кодировкой сайта, то параметр можно оставить пустым
	$this->base1CCodepage	= 'UTF-8';

	// Не перекодировать исходящие запросы. Иногда помогает установка в true, если кодировка сайта отличается от utf-8.
	$this->noRecodingOutQueries	= false;

	// Выполнять запросы к 1С методом POST. По умолчанию равен true.
	$this->usePOST		= true;

	// Путь к экземпляру класса (не URL, а файл на сервере)
	$this->scriptDir	= __DIR__;

	// Метод хеширования пароля. Возможные значения: "MD5", "SHA1", "SHA256"
	$this->encryptPass	= "";
		
?>