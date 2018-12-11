<?php

	include 'Database.php';
	
	$db = new Database("wdv341","root","","localhost");

	$sql = "SELECT * FROM wdv341_events";
	
	//$sql = "#)(@#)(#@$)(@#$)(@#)#)($";
	
	$db->preparePDO($sql);

	$rowCount = $db->executePDO();
	
	echo "<h3>$rowCount</h3>";

?>