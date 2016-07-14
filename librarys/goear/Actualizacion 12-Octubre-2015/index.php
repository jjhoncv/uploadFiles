<?php
$q = $_GET['q']; 
$p = $_GET['p']; 
$q = str_replace("+"," ",$q);
?>
<html>
    <head>
    	<title>Buscador de M&uacute;sica</title>
        <meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">
        <link rel="shortcut icon" type="image/x-icon" href="imagenes/cancion.gif" />
		<script type="text/javascript" src="all.js?123"></script>
	    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="style.css" rel="stylesheet" type="text/css">
        <script src="ajax.js" language="JavaScript"></script>
    <style type="text/css">
    body {
	background-color: #CCCCCC;
	}
	.label {
		display: inline;
		padding: .2em .6em .3em;
		font-size: 75%;
		font-weight: 700;
		line-height: 1;
		color: #fff;
		text-align: center;
		white-space: nowrap;
		vertical-align: baseline;
		border-radius: .25em;
	}
	.label-duracion{
		background-color: #337ab7;
	}
	.label-kbps{
		background-color: #d9534f;
	}
    </style>
    </head>
    <body Leftmargin="0px" Topmargin="0px">
    	<div align="center">
        	<p>&nbsp;</p>
       	  <p><img src="images/logo.png" height="139"><br /><br />
      	  </p>
        	<form method="GET" action="index.php">
            <fieldset>
            <legend>Buscar Musica:</legend>
                <input name="q" value="<?php if($q){ echo $q; } else { echo "Escribe aqui el artista/grupo o cancion!"; } ?>" onBlur="if (this.value == '') {this.value = 'Escribe aqui el artista/grupo o cancion!';}" onFocus="if (this.value == 'Escribe aqui el artista/grupo o cancion!') {this.value = '';}" type="text" size="50">
                <INPUT type="submit" value="Buscar Mp3">
                </fieldset>
            </form>
        <?php if($q) { ?>
       <div align=center name="resultado" id="resultado">
			<script language="JavaScript" type="text/javascript">
            	resultado('q=<?=$q?>&p=<?=$p?>');
            </script>
        </div>
        <hr width="675"></div>
        <div id="paginas" align="center">
        	<script language="JavaScript" type="text/javascript">
				 paginas('q=<?=$q?>&p=<?=$p?>');
			</script>
        </div>
        <?php } ?>
        </div>
       <center>Actualizaci&oacute;n por Deckso Gamez 
    </center><br /><br /><br /><br /><br /><br />
</body>
</html>