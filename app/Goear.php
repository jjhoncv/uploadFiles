<?php
//require("../app/utils/utils.php");
class Goear{

  private $_soundcloud_key;
  private $_limit;
  private $_max_size = 2; //10MB


  public function __construct(){
    $this->_limit = 25;
  }

  public function search($q, $page="0"){
    
    $results = $this->html("http://www.goear.com/search/" . $q . "/" . $page);

    if(count($results)>0){
            $total = 0;
            foreach ($results as $item) {
                $songs[] = array(
                'id'        => $item['id'],
                'title'     => $item['title'],
                'artist'    => $item['artist'],
                'cover'     => '',
                'duration'  => $item['duration'],
                'server'    => 'go'
            );
                $total++;
            }
        }
        return array(
            'total' => $total,
            'results' => $songs
        );
    
  }


  public function html($url, $referer="http://google.es"){
    $borrar = array("(",")","[","]","www.djfla.com.ar","www.back2electro.com","www.thedracko.tk","www.musicalocaza.tk","www.torrentazos.com","","www.",".com",".tk","jaipel",".co",".uni",".cc",".ar");
    $cargar = file_get_contents($url);
    preg_match("'<ol class=\"board_list results_list\">(.*?)</ol>'si", $cargar, $pre1);
    preg_match_all("'<a class=\"\" title=\"Escuchar (.*?)\" href=\"http://www.goear.com/listen/(.*?)/(.*?)\">(.*?)</a>'si", $pre1[1], $titulo);
    preg_match_all("'<li class=\"stats length\" title=\"Duración\">(.*?)</li>'si", $pre1[1], $length);
    preg_match_all("'<li class=\"band\"><a class=\"band_name\" href=\"(.*?)\">(.*?)</a></li>'si", $pre1[1], $band);
    preg_match_all("'<li class=\"stats (.*?)\" title=\"Kbps\">(.*?)<abbr title=\"Kilobit por segundo\">kbps</abbr></li>'si", $pre1[1], $kbps);
    $res = count($titulo[0]);

    if($res > 1){      
      for($i=0; $i < $res; $i++){
        $temp = $titulo[4][$i];
        $temp = strtolower($temp);
        $temp = ucwords($temp);
        $temp = str_replace($borrar, "",$temp);

        $songs[] = array(
          'title'   => $temp,
          'artist'  => $band[2][$i],
          'duration'=> $length[1][$i],
          'kbps'    => $kbps[2][$i],
          'id'      => $titulo[2][$i]
        );

      }
    }
    return $songs;
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