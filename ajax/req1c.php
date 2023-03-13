<?php
require('../v-can_site/init.php');
$vcan_site = new vcan_site();
$vcan_site->encodeArr($_GET);
$vcan_site->encodeArr($_POST);
$execParam = "";
if(isset($_POST["exec"])){
	$execParam = $_POST["exec"];
}else{
	if(isset($_GET["exec"])){
		$execParam = $_GET["exec"];
	}	
}
echo($vcan_site->execute('exec='.rawurlencode($execParam)));
?>