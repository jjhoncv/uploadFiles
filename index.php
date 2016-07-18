<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link href="statics/css/bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" media="all" rel="stylesheet" type="text/css">
	<link href="statics/css/bootstrap-3.3.6-dist/css/bootstrap.min.css" media="all" rel="stylesheet" type="text/css">
</head>
<body>
<form class="frm_search">
	<input type="text" class="txt_search" name="" value="" placeholder=""><br/>
	<button>Search</button>
</form>

<ul class="list">
</ul>

 <div class="music_player">
	<div class="controls">
  	<div class="prev">prev</div>
  	<div class="play">play</div>
  	<div class="stop">stop</div>
  	<div class="next">next</div>
  </div>
  <div class="controls_bar">
		<div class="progress_bar">
			<div class="bar"></div>
		</div>
	</div>
	<div class="time">
		<span class="minutes">04</span>:<span class="seconds">55</span>
	</div>
	<div class="control_search">
		<input type="text" class="search"/>
	</div>
	<div class="to_music_player">
		<ul></ul>
	</div>
</div>
<script type="text/template" id="tplItem">
	<li>
		<article data-index="{{= song.index}}">
			<a href="#" class="listen">Escuchar</a>
			<a href="#" class="remove">Quitar</a>
			<div class="title">{{= song.title}}</div>					
		</article>
	</li>
</script>
<script type="text/javascript" src="statics/js/jquery-1.12.4/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="statics/js/underscore-1.6.0/underscore.min.js"></script>
<script type="text/javascript" src="statics/css/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="statics/js/Mp3.js"></script>
<script type="text/javascript" src="statics/js/playList.js"></script>
<script type="text/javascript" src="statics/js/main.js"></script>
</body>
</html>