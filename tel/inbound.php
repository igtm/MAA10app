<?php
require dirname(__FILE__).'/../lib/twilio-php/Services/Twilio.php';
require dirname(__FILE__).'/../app/models/config.php';
mysql_connect('mysql572.phy.lolipop.jp','LAA0350474','2x2jycy9') or die(mysql_error());
mysql_select_db('LAA0350474-3tnmww');
mysql_query('SET NAMES UTF8');

function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
$response = new Services_Twilio_Twiml();
$cnt = 1;
if(!empty($_POST['Digits'])){
	$pin = $_POST['Digits'];
	$callSid = $_POST['CallSid'];
	
	$sql = sprintf("SELECT p.id,p.pin,t.name,p.status FROM MA10_projects p, MA10_targets t WHERE p.target_id=t.id AND p.pin=%d",mysql_real_escape_string($pin));
	$record = mysql_query($sql) or die(mysql_error());
	$table = mysql_fetch_assoc($record);
	
	if($table['status'] != 1 && !empty($table)){ // 既に実行済み
		$message_2 = '申し訳ございません。';
		$message_2 .= 'このプロジェクトは既に終了しています。';

		$response->say($message_2, array("language"=>"ja-jp"));	
		header("Content-Type : text/xml; charset=utf-8");
		print $response;
	}elseif($table){ // 正解
		$message_2 = 'ピンコードが確認されました。';
		$message_2 .= 'それでは、お名前と、';
		$message_2 .= h($table['name']).'さんへのメッセージを、';
		$message_2 .= '７秒以内で';
		$message_2 .= '録音して下さい。';

		$response->say($message_2, array("language"=>"ja-jp"));	
		$response->record(array(
						  'action' => 'inbound_record.php',
						  'maxLength' => 7,
						  'method' => "	POST"
						));
		header("Content-Type : text/xml; charset=utf-8");
		print $response;
		// CallSidとproject_idを入力
		$sql = sprintf("INSERT INTO MA10_voices (project_id, CallSid) VALUES (%d, '%s')",mysql_real_escape_string($table['id']),mysql_real_escape_string($callSid));
		$record = mysql_query($sql) or die(mysql_error());

	}else{ // 間違い
		$cnt++;
		$message_1 = 'ピンコードが間違っています。';
		$message_1 .= 'ピンコードを入力して下さい。';
		
		$response->say($message_1, array("language"=>"ja-jp"));
		$gather = $response->gather(array('numDigits' => 5));
		header("Content-Type : text/xml; charset=utf-8");
		print $response;
	}
}else{
	$message_1 = 'こちらは、ファイトコールです。';
	$message_1 .= 'ピンコードを入力して下さい。';
	
	$response->say($message_1, array("language"=>"ja-jp"));
	$gather = $response->gather(array('numDigits' => 5,'timeout'=>10));
	$response->redirect('http://i-and-i.main.jp/API/MAA10app/tel/inbound.php',array('method'=>'GET'));
	header("Content-Type : text/xml; charset=utf-8");
	print $response;
}
?>