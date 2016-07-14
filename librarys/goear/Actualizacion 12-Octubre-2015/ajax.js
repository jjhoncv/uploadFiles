function cerrar(div)
{
		document.getElementById(div).style.display = 'none';
		document.getElementById(div).innerHTML = '';
}
function get_ajax(url,capa,metodo){ 
	var ajax=creaAjax();
	var capaContenedora = document.getElementById(capa);
	if (metodo.toUpperCase()=='GET'){
		ajax.open ('GET', url, true);
		ajax.onreadystatechange = function() {
			if (ajax.readyState==1){
				capaContenedora.innerHTML= "<center><img src=\"imagenes/down.gif\" /><br><font color='000000'><b>Cargando...</b></font></center>";
			} else if (ajax.readyState==4){ 
				if(ajax.status==200){ 	            
					document.getElementById(capa).innerHTML=ajax.responseText; 
				}else if(ajax.status==404){
					capaContenedora.innerHTML = "<CENTER><H2><B>ERROR 404</B></H2>EL ARTISTA NO ESTA</CENTER>";
				} else {
					capaContenedora.innerHTML = "Error: ".ajax.status;
				}
			} // ****
		}
		ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		ajax.send(null);
		return
	}
}

function creaAjax(){
  var objetoAjax=false;
	  try{objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");}
	      catch(e){try {objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");} 
	    catch (E){objetoAjax = false;}}
     if(!objetoAjax && typeof XMLHttpRequest!='undefined') {
  objetoAjax = new XMLHttpRequest();}  return objetoAjax;
}

function resultado(contenido){
				var url='ajax/buscar.php?'+ contenido +'';// Vota Resultado
				var capa='resultado';
				var metodo='get';
				get_ajax(url,capa,metodo);
}
function paginas(contenido){
				var url='ajax/paginar.php?'+ contenido +'';// Vota Paginas
				var capa='paginas';
				var metodo='get';
				get_ajax(url,capa,metodo);
}