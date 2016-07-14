<?php

$q = htmlentities($_GET['q']); 
$p = (empty($_GET['p'])) ? "1" : $_GET['p']; 
$p--;
$q = str_replace(" ","%20",$q); 

$borrar = array("(",")","[","]","www.djfla.com.ar","www.back2electro.com","www.thedracko.tk","www.musicalocaza.tk","www.torrentazos.com","","www.",".com",".tk","jaipel",".co",".uni",".cc",".ar");

$goear = "http://www.goear.com/search/".$q."/".$p;
$cargar = file_get_contents($goear);

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
		$tit[$i]['titulo'] = $temp;
		$temp = $band[2][$i];
		$tit[$i]['artista'] = $temp;
		$temp = $length[1][$i];
		$tit[$i]['duracion'] = $temp;
		$temp = $kbps[2][$i];
		$tit[$i]['kbps'] = $temp;
		$temp = $titulo[2][$i];
		$tit[$i]['link'] = $temp;
	}
	
	unset($tit[10]);
	foreach($tit as $k => $v){
		$color = ($k%2==0) ? "#f3faff" : "#e6edf3";
		$numl = $k + 1;
	if($p > 1) { $x = ($p*10) - 10; ;$numl = $k+$x+1; }
?>
    <table width="750" border="0" align="center" cellpadding="5" cellspacing="5" bgcolor="<?=$color?>"><tbody>
	<tr>
		<td width="640"><b><font color="#FF00DD"><?=$numl?></font> <?=$v['titulo']?> - <?=$v['artista']?></b></font></td>
		<td width="30"><b><span class="label label-duracion"><?=$v['duracion']?></span></b></font></td>
		<td width="30"><b><span class="label label-kbps"> <?=$v['kbps']?> kbps</span></b></font></td>
		<td width="30" align="right"><div class="playerr"></div></td>
		<td width="10" align="right"><a rel="nofollow" title="" class="play" href="javascript:;" onclick="showpl(this,'<?=$v['link']?>','play');return false;">Play</a></td>
		<td width="75" align="right"><a download="<?=$v['titulo']?>.mp3" href="http://www.goear.com/action/sound/get/<?=$v['link']?>"><img align="center" alt="Descargar" border="0" src="../imagenes/download.png" title="Click para descargar"  /></a></td>
    </tr>	
	</table></tbody>
<?php
}
} else {
	echo "<b><center><h1>Sin resultados</h1></center></b>";
}
?>