<?php
require("app/Musicaq.php");
require("app/Goear.php");
//$letters = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0-9"];




function getArtistByLetterView($index_letter){
	$letters = ["a"];
	$musicaq = new Musicaq();
	
	$artists = $musicaq->getArtistByLetter($letters[$index_letter]);
	if(count($artists)>0){
		$index_artista = 0;		
		$artista = $artists[$index_artista];
		$songs = getSongsByArtista($artista);

		if(!recursiveSongs($artista, $songs)){
			$index_letter++;
			getArtistByLetterView($index_letter);
		}
	}else{
		if($index_letter < count($letters)){
			$index_letter++;
			getArtistByLetterView($index_letter);			
		}
	}
}


function recursiveSongs($artista, $songs){
	if($songs["total"]>0){
		$page = 0;
		if(!createSongs($artista, $songs, $page)){
			$index_artista++;
			$page = 0;

			$artista = $artists[$index_artista];
			$songs = getSongsByArtista($artista);

			recursiveSongs($artista, $songs);
		}
	}else{
		return false;
	}
}


function getSongsByArtista($artista){	
	$goear = new Goear();
	$data = $goear->search($artista);
	return $data;	
}

function createSongs($artista, $songs, $page){
	if($songs["total"]>0){
		$file = "songs.json";
		$inp = file_get_contents($file);
		$tempArray = json_decode($inp);
		array_push($tempArray, $songs["results"]);
		$jsonData = json_encode($tempArray);
		$status = file_put_contents($file, $jsonData);

		$page++;
		$goear = new Goear();
		$songs = $goear->search($artista, $page);

		createSongs($artista, $songs, $page);
	}else{
		return false;
	}
}


getArtistByLetterView(0);
?>