<?php
/*
*************************************************************
******************* WWW.MARCOFBBB.COM.AR ********************
*************************************************************
*/
// Tomamos variables
$q = htmlentities($_GET['q']); // Texto que vamos a buscar
$p = (empty($_GET['p'])) ? "1" : $_GET['p']; // En la pagina que nos encontramos
$p--;
$q = str_replace(" ","%20",$q); // Ponemos los espacios correspondientes
// Entramos a goear
$goear = "http://www.goear.com/search/".$q."/".$p;
$cargar = @join("",file($goear));
preg_match_all("/<li(.*?)><a href=\"http:\/\/www\.goear\.com\/search\/(.*?)\/.*?\">(.*?)<\/a><\/li>/",$cargar, $pre);
$res = count($pre[1]);
// Si no hay resultados vamos a saltear todo
if($res >= 1){
echo "<p align=center><b>Paginas: </b>";
if($p > 1){ echo "<a href=\"index.php?q=".$q."&p=".($p-1)."\"> << Anterior </a>"; }
	foreach($pre[3] as $k => $v){
		if($p+1 != $v){ 
			echo "<a href=\"index.php?q=".$q."&p=".($v)."\"> ".$v." </a>"; 
		} else {
			echo "<strong>".$v."</strong>";
		}
	}
if($p < end($pre[2])){ echo "<a href=\"index.php?q=".$q."&p=".($p+1)."\"> Siguiente >> </a>"; }
echo "</p>";
}
?>