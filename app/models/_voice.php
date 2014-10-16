<?php

require_once dirname(__FILE__).'/../../lib/docomo/edit_voice.php';
require_once dirname(__FILE__).'/../../lib/getID3/demos/demo.browse.php';

define("SAVE_WAV_DIR",dirname(__FILE__).'/voices/'); //音声保存先パス


function execute_project($project_id){
	$returns = get_voices($project_id);
	$a = array();
	foreach ($returns as $return){
		$a[] = VOICE_URL.$return['voice'];
	}
	list($wav_path,$playtime) = connect_all_wav($a);
	set_comp_voice($wav_path,$playtime);
	change_status($project_id,3);//実行待ち状態
	
	return array($wav_path,$playtime);
}

function change_status($project_id,$status){
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("UPDATE MA10_projects SET status=:status WHERE id=:project_id"
);
	$stmt -> bindValue(":status",$status, PDO::PARAM_INT);
	$stmt -> bindValue(":project_id",$project_id, PDO::PARAM_INT);
	$stmt -> execute();
}
function set_comp_voice($comp_voice,$playtime){
	$pdo = get_pdo();
	$stmt = $pdo -> prepare("UPDATE MA10_projects SET comp_voice=:comp_voice,
	playtime=:playtime WHERE id=:project_id");
	$stmt -> bindValue(":comp_voice",$comp_voice, PDO::PARAM_INT);
	$stmt -> bindValue(":playtime",$playtime, PDO::PARAM_INT);
	$stmt -> execute();
}



/*
/////////SAMPLE_USAGE/////////
$u1 = 'http://api.twilio.com/2010-04-01/Accounts/AC5b10badadd6e95dd38c77c9bf3982201/Recordings/RE8a4e157f6240f3877756dad6eb5e304b';
$u2 = 'http://api.twilio.com/2010-04-01/Accounts/AC5b10badadd6e95dd38c77c9bf3982201/Recordings/RE2d3028f886a4ff3f1221821b369f24de';
$urls = [$u1,$u2];

var_dump(connect_all_wav($urls))."\n";
*/


/*
connect_all_wavメソッド
@入力：複数のURLを格納した配列;
@返り値：pathとplaytime(秒数)
array(2) {
  ["path"]=>
  string(60) "YOUR_PROJECT_DIR/app/models/voices/wav_2014-10-13-Mon@543b711c3c239.wav"
  ["playtime"]=>
  float(10.255375)
}
*/
function connect_all_wav($wav_urls){

	$all_wav = new Wavedata();
	foreach ($wav_urls as $url){

		if($all_wav->noData()){
			$all_wav->loadFile($url);
			continue;
		}
		
		$wav = new Wavedata();
		$wav->loadFile($url);
		$all_wav->WaveConnect($wav);
	}

	//音声ファイル保存
	$id = uniqid();
	$filename = 'wav_'.date('Y-m-d-D@').$id.'.wav';
	$wav_path = SAVE_WAV_DIR.$filename;
	$all_wav->SaveFile($wav_path);
	print $wav_path."\n";

	//音声再選時間取得
	$getID3 = new getID3();
	$info = $getID3->analyze($wav_path);
	$playtime = $info["playtime_seconds"];


	$results[] = $wav_path; //保存先パス
	$results[] = $playtime; //再生時間[秒数]

	return $results;
}

//Reference Site

// http://stackoverflow.com/questions/5180730/string-date-current-date-time
// http://stackoverflow.com/questions/10161881/how-to-generate-a-unique-digital-id-in-php
// http://web-codery.com/php/135
// http://dqn.sakusakutto.jp/2013/05/php_require_once_include_once_include_path.html
// http://www.tryphp.net/2012/03/01/phpsample-date-today/

// http://qiita.com/imos/items/43525b5ac5800787910c
// http://getid3.sourceforge.net/

?>