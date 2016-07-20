<?php

 if(basename($_SERVER['PHP_SELF'])=="Connection.php")exit;

class Connection{

	private $link	= 	0;
	private $host ;	
	private $user ;
	private $psw  ;
	private $db   ;

	public function __construct($host, $user, $psw, $db){
		$this->host=	$host;
		$this->user=	$user;
		$this->psw	=	$psw;
		$this->db	=	$db;	
	
		$this->link = @mysql_connect($this->host,$this->user,$this->psw) or die(mysql_error() ."error al conectarse al servidor");
		if($db==""){
			@mysql_select_db($this->db,$this->link);
		}else{
			@mysql_select_db($db,$this->link);
		}
		
		return $this->link;
	}
}

?>