<?php
// Дерево значений
require('../v-can_site/init.php');
$vcan_site = new vcan_site();
$vcan_site->encodeArr($_GET);
$vcan_site->encodeArr($_POST);
echo($vcan_site->execute('exec='.rawurlencode('КэнСайтСервер.СекцияФормыДеревоЗначений(ПараметрыЗапроса)')));
?>
