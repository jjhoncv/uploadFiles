<?php
require("app/SoundCloud.php");
require("app/Mp3yox.php");
require("app/Goear.php");
require("app/Musicaq.php");

if(isset($_POST["method"])  && !empty($_POST["method"])){
	
	$method 	= $_POST["method"];
	$service 	= $_POST["service"];	
	$service = new $service();	

	if($method == "getArtistByLetter"){		
		$letter = $_POST["letter"];	
		$data 	= $service->$method($letter);
		echo json_encode($data);
	}

	if($method == "search"){
		$artist = $_POST["artist"];
		$page 	= $_POST["page"];	
		$data 	= $service->$method($artist, $page);
		echo json_encode($data);
	}

	if($method == "add"){
		$artist	= $_POST["artist"];
		$data 	= $_POST["data"];
		$data 	= $service->$method($data, $artist);
		echo json_encode($data);
	}

	if($method == "saveKeys"){
		$keys		= $_POST["keys"];
		$data 	= $service->$method($keys);
		echo json_encode($data);
	}

	if($method == "loadKeys"){		
		$data 	= $service->$method();
		echo json_encode($data);
	}

}
?>