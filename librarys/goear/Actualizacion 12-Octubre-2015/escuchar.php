<?php
function convertir_iso($v){
	$v = preg_replace('/[^!-%\x27-;=?-~<>&\x09\x0a\x0d\x0B ]/e', '"&#".ord("$0").chr(59)', $v);
	$$k = preg_replace('/Ã&#([0-9]+);/e', '"&#".((int) \\1 + 64).";"', $v);
	return($$k);
}
$_id = htmlentities($_GET['id']);
$_ip = substr($_id, 0, 1);
if($_id){
  $load = 'http://www.goear.com/playersong/'.$_id.'';
        $xml = @simplexml_load_file($load);
        if ($xml) {
            $path = $xml->playlist->track['href'];
            $title = $xml->playlist->track['title'];
            $name = $xml->playlist->track['title'];
         } else {
			exit("error");
		}
}
$name = strtoupper ($name);
$name = convertir_iso($name);
?>
<html>
	<head>
        <title>Escuchando <?=$name?> en <?=$sitio?> <?=$title?>.</title>
        <LINK href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body Leftmargin="0px" Topmargin="0px">
    	<table align="center" width="295" border="0">
          <tr>
            <td align="center" valign="top" width="295" height="15"><img src="imagenes/listen.gif" /></td>
          </tr>
          <tr>
            <td align="center" valign="middle" width="295" height="100%"><img src="imagenes/escucha.gif" align="right" /><img src="imagenes/cancion.gif" align="left"/><b><?=$name;?></b></td>
          </tr>
          <tr>
            <td align="center" valign="top" width="295" height="25">
            <object type="application/x-shockwave-flash" data="player.swf" width="290" height="24" id="audioplayer2">
            <param name="movie" value="player.swf" />
            <param name="FlashVars" value="loop=yes&autostart=yes&soundFile=<?=$path;?>&amp;playerID=2&amp;bg=0xCDDFF3&amp;leftbg=0x357DCE&amp;lefticon=0xF2F2F2&amp;rightbg=0xF06A51&amp;rightbghover=0xAF2910&amp;righticon=0xF2F2F2&amp;righticonhover=0xFFFFFF&amp;text=0x357DCE&amp;slider=0x357DCE&amp;track=0xFFFFFF&amp;border=0xFFFFFF&amp;loader=0xAF2910&amp;" />
            <param name="quality" value="high" />
            <param name="menu" value="false" />
            <param name="bgcolor" value="#FFFFFF" />
            </object><br />
            
            <a download="<?=$name;?>.mp3" href=<?=$path;?>><img align="center" alt="Descargar" border="0" src="imagenes/download.gif" title="Para descargar dar Click derecho > Guardar enlace como" /></a> 
            </td>
          </tr>
    	</table>
    </body>
</html>