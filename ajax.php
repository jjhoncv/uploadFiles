<?php
require("app/SoundCloud.php");
require("app/Mp3yox.php");
require("app/Goear.php");
if(isset($_POST["q"])  && !empty($_POST["q"])){
	$q = $_POST["q"];
	$service = $_POST["service"];
	$service = new $service();
	$data = $service->search($q);
	echo json_encode($data);
}
?>