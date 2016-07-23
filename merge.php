<?php
$file = "statics/results.json";
$fileok = "statics/results_ok.json";
$inp = file_get_contents($file);
$json_array = json_decode($inp, TRUE);

$new_array = array();
$exists    = array();
foreach( $json_array as $element ) {
    if( !in_array( $element['title'], $exists )) {
        $new_array[] = $element;
        $exists[]    = $element['title'];
    }
}

$jsonData = json_encode($new_array);
$status = file_put_contents($fileok, $jsonData);
if($status){
	echo "listo!";
}
?>