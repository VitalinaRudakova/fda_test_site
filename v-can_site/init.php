<?
// (c) 2012-2017 Юрий Лазаренко, г. Севастополь
// Почта lazarenkoyv@mail.ru
// Скайп lazarenkoyv
// v-can.Site
// v 3.3.0.3
// 29.02.2020

class vcan_site{

	public $base1CURL;	// URL http-сервиса 1С
	public $siteID;		// Идентификатор сайта
	public $siteCodepage;	// Кодовая страница сайта
	public $base1CCodepage;	// Кодовая страница 1С
	public $noRecodingOutQueries; // Не кодировать исходящие запросы. Иногда пригождается на сайтах с кодировкой, отличной от utf-8.
	public $usePOST;	// Использовать POST-запросы к 1С
	public $onError;	// Действие, которое необходимо выполнять при получении от 1С ошибочных данных.
				// Возможны варианты:
				// ShowMessage - отобразить сообщение
				// RequireFile - подключение файла и отображение его содержимого вместо ответа 1С
				// Redirect - перенаправление на указанный URL
	public $onErrorData;	// Данные для действия при ошибке: строка-сообщение об ошибке, путь к файлу с соощением об ошибке
	public $scriptDir;		// Путь к скрипту (не URL, а файл на сервере)
	public $encryptPass;	// Метод хеширования пароля. Возможные значения: "MD5", "SHA1", "SHA256"
	public $sessionID;		// Идентификатор сессии посетителя сайта

	public function __construct($paramsScriptName = '', $base1CURL = '', $siteID = '', $siteCodepage = '', $base1CCodepage = '', $usePOST = true){

		// Подключение скрипта с параметрами
		if ($paramsScriptName === ''){
			require_once 'init_params.php';
		}else{
			require_once $paramsScriptName;
		}

		// Изменение настроек, ели они были переданы в параметрах
		if($base1CURL != '')		$this->base1CURL	= $base1CURL;
		if($siteID != '')	  		$this->siteID		= $siteID;
		if($siteCodepage != '')		$this->siteCodepage	= $siteCodepage;
		if($base1CCodepage != '')	$this->base1CCodepage = $base1CCodepage;
		if($usePOST != true)		$this->usePOST	= $usePOST;
		
		// Дополнительные параметры класса
		if (isset($_COOKIE['vcanSessionID'])) $this->sessionID = $_COOKIE['vcanSessionID'];
		// Вторая строка добавлена для совместимости с предыдущими версиями шаблонов страниц
		if (isset($_COOKIE['vcan_sessionid'])) $this->sessionID = $_COOKIE['vcan_sessionid']; 

		// Эту строку можно раскомментировать для отладки
		//echo "Создан объект vcan_site с параметрами: $this->base1CURL, $this->siteCodepage, $this->base1CCodepage, $this->usePOST, $this->scriptDir <br>";
	}

	// Добавляет параметр к post, проверяя предварительно, не задан ли он уже
	function addParamToPost($post, $newParamName, $newParamValue){
		if(strrpos($post, '&'.$newParamName.'=') == false &&  strlen($newParamValue) > 0){
			// Данный параметр не найден в post, добавляем его
			//$post = $post . '&' . $newParamName . '=' . htmlspecialchars(urldecode($newParamValue));
			// !!!!! Проверить, скорее всего если у сайта кодировка отличается от кодировки сайта, то понадобится urldecode, как это сделано в строке выше.
			$post = $post . '&' . $newParamName . '=' . htmlspecialchars($newParamValue);
		}
		return $post;
	}
	
	// Выполняет запрос к 1С и возвращает результат
	function curl($method='', $post = ''){
		// Флаг "Необходима перекодировка", устанавливается автоматически
		if ($this->siteCodepage == $this->base1CCodepage){
			$recodingNeed = false;
		}else{
			$recodingNeed = true;
		}
		// Заменяем пробелы на %20. Полный urlencode не делаем, чтобы не ломать конструкции языка 1С
		$post = str_replace(" ", "%20", $post);

		// Добавление обязательных параметров запроса
		// Идентификатор сайта
		$post = $this->addParamToPost($post, 'siteID', $this->siteID);
		// IP посетителя
		$post = $this->addParamToPost($post, 'vcan_userremoteip', $_SERVER['REMOTE_ADDR']);
		// Идентификатор сессии
		if (isset($this->sessionID)) $post = $this->addParamToPost($post, 'vcan_sessionid', $this->sessionID);
// Для тестирования
// echo("<pre>");
// print_r($_GET);
// echo("</pre>");
		// Добавление параметров, переданных в $_POST и $_GET формы
		for (reset($_POST); ($key = key($_POST)); next($_POST))
		{
			$post = $this->addParamToPost($post, $key, str_replace(" ", "%20", $_POST[$key]));
		}		
		for (reset($_GET); ($key = key($_GET)); next($_GET))
		{
			$post = $this->addParamToPost($post, $key, str_replace(" ", "%20", $_GET[$key]));
		}		

		// Инициализация и установка параметров
		$ch = curl_init();
		$headers = array("siteid: " . $this->siteID,
						 "sitecodepage: " . $this->siteCodepage);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		// Перекодировка параметров
		if ($recodingNeed && $this->noRecodingOutQueries != true){
			$post = mb_convert_encoding($post, $this->base1CCodepage, $this->siteCodepage); // !!!!! Отмену перекодировки исходящих запросов добавить в init_params
		}
		if ($this->usePOST){
			curl_setopt($ch, CURLOPT_POST, 1);
			if(count($_FILES)==0){
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			}else{
				// В параметрах запроса есть файлы. Передаем их только в случае использования POST-запросов.
				// Преобразуем строку параметров $post в массив и добавляем в него файлы.
				$postArr = array();
				parse_str($post, $postArr);
				$postArr['vcanupfile'] = base64_encode(file_get_contents($_FILES['vcanupfile']['tmp_name']));
				$postArr['vcanupfilename'] = $_FILES['vcanupfile']['name'];
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postArr);
			}
			$fullURL = $this->base1CURL . 'v-can.site/' . $method;
		}else{
			$fullURL = $this->base1CURL . 'v-can.site/' . $method . '?' . $post;
		}
		curl_setopt($ch, CURLOPT_URL, $fullURL);
		// Выполнение запроса
		$result = curl_exec($ch);
		curl_close($ch);
		
		// Перекодировка результата
		if ($recodingNeed){
			$result = mb_convert_encoding($result, $this->siteCodepage, $this->base1CCodepage);
		}
		if(strlen($result) > 0 && $result{0} == '?'){
			// Удаляем предваряющий служебный знак вопроса в результате
			$result{0} = '';
		}
		
		// Возврат результата
		return $result;
	}

	// Вызов 1С, определение корректности возвращенного результата, возврат результата или сообщения об ошибке
	function request1C($method='', $post = ''){
		// Запрос к 1С
		$responce = $this->curl($method, $post);
		 if(substr($responce, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
			 $responce= substr($responce, 3);
		 }
		$responce = trim($responce);
		// Проверим статус запроса
		$StatusOK = false;
		if(strlen($responce) >= 20){ // 20 - длина строки "<!--v-can.Status: OK"
			//if(strpos($responce, "<!--v-can.Status: OK")){
			if(strpos($responce, "v-can.Status: OK")){
				// 1С вернула корректный ответ. Удалим из него данные о статусе и вернем результат.
				$StatusOK = true;
				$responce = substr($responce, strpos($responce, "v-can.Status: OK") + 19);
			}
		}
		// Возврат результата или обработка ошибки
		if ($StatusOK){
			// Получен корректный ответ, возвращаем его в качестве результата
			return $responce;
		}else{
			// Ответ от 1С некорректный, выполняем обработку ошибки
			// Очищаем результат, чтобы в случае ошибки если не заданы обработчики вернуть просто пустую строку.
			// Отмена. Теперь если обработчики не заданы, то возвращаетм ответ 1С, так как там в большинстве случаев собержится сообщение об ошибке.
			//$responce = "";
			if($this->onError == "ShowMessage"){
				// Выводим сообщение
				$responce = $this->onErrorData;
			}elseif($this->onError == "RequireFile"){
				// Подключаем файл
				require $this->onErrorData;
			}elseif($this->onError == "Redirect"){
				// Перенаправление
				header('Location: ' . $this->onErrorData);
				die();
			}
		}
		return $responce;
	}

	// Выполняет метод execute 
	public function execute($params){
		$content = $this->request1C('execute', $params);
		return $content;
	}

	// Загружает файл
	public function loadfile($params){
		// Запрос к 1С
		$responce = $this->curl('execute', $params);
		return $responce;
	}
	
	// Выполняет метод site
	public function site($params){
		$content = $this->request1C('module', $params);
		return $content;
	}

	// Запуск компоненты с передачей ей параметров, заданных пользователем
	public function useComponent($componentName, $additionalParams){
		// Определение пути к скрипту компоненты
		$componentPath = $this->scriptDir . '/' . $componentName . '/component.php';
		// Проверим наличие указанного скрипта
		if (file_exists($componentPath)){
			// Все в порядке, подключаем компоненту
			require($componentPath);
		}else{
			// Указанный путь не найден
			echo('Ошибка подключения компоненты "' . $componentName . '", не найден файл "' . $componentPath . '"');
		}
	}
	public function encodeArr(&$arr){
		reset($arr);
		foreach ($arr as $key => $value){
			$arr[$key] = mb_convert_encoding($value." ", "UTF-8", "windows-1251, UTF-8");
			$arr[$key] = substr($arr[$key], 0, strlen($arr[$key]) - 1);
		}
	}
	
}

?>