<?php 
$filename = date("YmdHis").rand(0,999).".mp3";
$file = "https://api.twilio.com/cowbell.mp3";
var_dump(file_get_contents($file));
if(move_uploaded_file($file, "/API/MAA10app/voices/".$filename)){
	var_dump("OK!");
}else{
	var_dump("False");
}
?>