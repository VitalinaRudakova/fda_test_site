<?
	header('Content-Type: application/x-octet-stream');
	header('Content-Disposition: attachment; filename=' . $_GET['fn']);
	if($ch = curl_init()){
		require('../../v-can_site/init.php');
		$vcan_site = new vcan_site();
		$headers = array("siteid: " . $vcan_site->siteID,
						 "sitecodepage: " . $vcan_site->siteCodepage,
						 "vcan_userremoteip:".$_SERVER['REMOTE_ADDR'],
						 "vcan_sessionid:".$vcan_site->sessionID);
		if(isset($vcan_site->user1C) && $vcan_site->user1C !== ''){
			// В параметрах указаны логин и пароль пользователя 1С, выполняем авторизацию.
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);       
			curl_setopt($ch, CURLOPT_USERPWD, $vcan_site->user1C . ":" . $vcan_site->pass1C);
		}
		$fullURL = $vcan_site->base1CURL.'/v-can.site/execute?exec='.rawurlencode('ЛичныйКабинетИнициатораСайт.СкачатьФайл(ПараметрыЗапроса)').'&fileref='.rawurlencode($_GET['fileref']);
		$fullURL = str_replace("/hs//", "/hs/", $fullURL);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $fullURL);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		$result = curl_exec($ch);
		echo $result;
		curl_close($ch);
	}
?>