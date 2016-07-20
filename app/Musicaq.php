<?php
/*require("Connection.php");
require("Consulta.php");*/

class Musicaq{

  private $_soundcloud_key;
  private $_limit;
  private $_max_size = 2; //10MB


  public function __construct(){
    $this->_limit = 25;
    //$link = new Connection("localhost", "root", "frontend", "dmv");
  }

  public function getArtistByLetter($letter){
    
    return $this->html("http://musicaq.me/artista/" . $letter . ".html" );
    
    
  }


  public function html($url, $referer="http://google.es"){
    $cargar = file_get_contents($url);
    preg_match("'<ul id=\"result-letters\">(.*?)</ul>'si", $cargar, $pre1);    
    preg_match_all("'<a href=\"http://musicaq.me/descargar-mp3/(.*?)\">(.*?)</a>'si", $pre1[1], $titulo);    
    $res = count($titulo[0]);
    $artists = [];
    if($res > 1){
      for($i=0; $i < $res; $i++){
        $artists[] = $titulo[2][$i];
      }
    }
    return $artists;    
  }

  public function add($data, $q){    
    $count = 0;
    foreach($data as $val){
      if($this->insert($val, $q)){
        $count++;
        if($count == count($data)){
          $messages["status"]=true;
          return $messages;
        }
      }
    }
  }
  
  public function sanitize($data) {   
    $data = trim($data);    
    if(get_magic_quotes_gpc()){
      $data = stripslashes($data);
    }    
    $data = mysql_real_escape_string($data);     
    return $data;
  }

  public function insert($data, $q){
    $id_mp3       = $this->sanitize($data["id"]);
    $q_mp3        = $this->sanitize($q);
    $title_mp3    = $this->sanitize($data["title"]);
    $artist_mp3   = $this->sanitize($data["artist"]);
    $duration_mp3 = $this->sanitize($data["duration"]);

    /*$query = new Consulta("INSERT INTO mp3 VALUES ('', '".$q_mp3."', '".$id_mp3."','".$title_mp3."', '".$artist_mp3."', '".$duration_mp3."')");    
    if($query){
      return true;
    }else{
      return false;
    }*/

    $file = "statics/results.json";
    $inp = file_get_contents($file);
    $tempArray = json_decode($inp);
    array_push($tempArray, $data);
    $jsonData = json_encode($tempArray);
    $status = file_put_contents($file, $jsonData);
    if ($status){
      return true;
    }else{
      return false;
    }
  }

  public function download($id){
    $from = "https://api.soundcloud.com/tracks/".$id."/stream?client_id=" . $this->_soundcloud_key;
    
    $headers = get_headers($from, 1);
    $size = $headers["Content-Length"][1];
    if ($size <= $this->_max_size * 1000000){
      copy($from, RUTE_MP3 . $id . ".mp3");
      $data["status"] = true;
      $data["message"] = "The file is downloaded";
      $data["data"] = array("id"=> $id, "size"=>formatSizeUnits($size));
    }else{
      $data["status"] = false;
      $data["message"] = "Exceeded file size";
      $data["data"] = array("id"=> $id, "size"=>formatSizeUnits($size));
    }
    return $data;
  }  

}
?>