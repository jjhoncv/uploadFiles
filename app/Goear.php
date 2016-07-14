<?php
//require("../app/utils/utils.php");
class Goear{

  private $_soundcloud_key;
  private $_limit;
  private $_max_size = 2; //10MB


  public function __construct(){
    $this->_soundcloud_key = "7b356f9fbeeade2f83c203aeb963e62e";
    $this->_limit = 25;
  }

  public function search($q){
    
    $html = $this->html("http://api.soundcloud.com/tracks.json?callback=&client_id=" . $this->_soundcloud_key . "&track_types=original&filter=downloadable&q=$q&limit=" . $this->_limit);

    $results = json_decode($html);
    $songs          = [];
    $total          = 0;

    if(count($results)>0){
            foreach ($results as $item) {
                $songs[] = array(
                'id'        => $item->id,
                'title'     => $item->title,
                'artist'    => '',
                'cover'     => '',
                'duration'  => '',
                'server'    => 'sc'
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
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Seguir URL al momento de hacer curl
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // controla tiempo de espera al buscar.
        curl_setopt($ch, CURLOPT_URL, $url);
        $buffer = curl_exec($ch);
        curl_close($ch);
        return $buffer;
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