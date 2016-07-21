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
		$artista = str_replace(" ","+",$artists[$index_artista]);
		$songs = getSongsByArtista($artista);

		if(!recursiveSongs($artista, $songs, $index_artista, $artists)){
			if($index_letter < count($letters) -1){
				$index_letter++;
				getArtistByLetterView($index_letter);				
			}
		}
	}else{
		if($index_letter < count($letters) -1){
			$index_letter++;
			getArtistByLetterView($index_letter);			
		}
	}
}


function recursiveSongs($artista, $songs, $index_artista, $artists){

	//echo "artista : " . $artists[$index_artista];

	if($songs["total"]>0){
		$page = 0;
		if(!createSongs($artista, $songs, $page)){

			$index_artista++;
			
			$artista = str_replace(" ","+",$artists[$index_artista]);
			$songs = getSongsByArtista($artista);

			recursiveSongs($artista, $songs, $index_artista, $artists);
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
	
	echo "canciones : $artista | page : (" . $page . ") | total songs : " . $songs['total'] . "<pre>";
	print_r($songs);
	echo "</pre>";

	if($songs["total"]>0){
		$file = "songs.json";
		$inp = file_get_contents($file);
		$tempArray = json_decode($inp);
		
		if (count($tempArray)>0){
			
			$results = $songs["results"];

			foreach ($results as $item) {
				$tempArray[] = array(
					'id'        => $item['id'],
	        'title'     => $item['title'],
	        'artist'    => $item['artist'],
	        'cover'     => $item['cover'],
	        'duration'  => $item['duration'],
	        'server'    => $item['server'],
	        '_artist'   => $item['_artist'],
	        '_page'     => $item['_page']
				);
			}
		}else{
			$tempArray = $songs["results"];
		}

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