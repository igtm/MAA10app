<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$Voice = new Voice();

$returns = $Voice->get_untextized();
if($returns){
	foreach ($returns as $return){
		voice_to_text($Voice,$return);
	}
}
function voice_to_text($Voice,$return) {
	$voice = $return['voice'];
	$id = $return['id'];
	$get = http_build_query(
          array(
            'voice' => $voice,
            'account_id' => ACCOUNT_SID));
	$url= 'http://54.64.141.117/voicehub/voicetotext_.php?'.$get;
	$context = stream_context_create(array(
		'http'=>array(
				'ignore_errors' => true,
				'method' => 'GET',
				'header' => "User-Agent: OreOreAgent\r\n")));
	$body = file_get_contents($url,false,$context);	
	$memo = $body;
	$Voice->set_memo($id,$memo);
}

?>