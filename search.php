<?php
require("app/Musicaq.php");
require("app/Goear.php");
//$letters = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0-9"];
$letters = ["a"];

$songs = [];
$musicaq = new Musicaq();

for($i=0; $i<count($letters); $i++){
	$artists = $musicaq->getArtistByLetter($letters[$i]);
	$page = 0;
	
	echo "letter : " . $letters[$i] . "<br/>";

	for($j=0; $j<count($artists); $j++){
		$artist = str_replace(" ","+",$artists[$j]);

		echo "artist : " . $artist . "<br/>";

		$goear = new Goear();
		
		for($page=0; $page<40; $page++){
			$data= $goear->search($artist, $page);
			$songs[] = $data;
			if(count($data)==0){
				break;
			}
		}

		

		/*if(count($data)>0){
		}else{
			$page = 0;
		}*/

	}
}
?>