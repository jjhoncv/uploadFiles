<?php
require("app/SoundCloud.php");
require("app/Mp3yox.php");
require("app/Goear.php");

if(isset($_POST["method"])  && !empty($_POST["method"])){
	
	$method 	= $_POST["method"];
	$service 	= $_POST["service"];	
	$service = new $service();	

	if($method == "search"){
		$q 		= $_POST["q"];
		$page = $_POST["page"];	
		$data = $service->$method($q, $page);
		echo json_encode($data);
	}

	if($method == "add"){
		$q 		= $_POST["q"];
		$data = $_POST["data"];
		$data = $service->$method($data, $q);
		echo json_encode($data);
	}

}
?>