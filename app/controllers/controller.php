<?php 
require dirname(__FILE__).'/../models/model.php';
require_once dirname(__FILE__).'/../../lib/docomo/edit_voice.php';
require_once dirname(__FILE__).'/../../lib/getID3/demos/demo.browse.php';

define("SAVE_WAV_DIR",'/home/users/2/main.jp-i-and-i/web/API/MAA10app/app/models/voices/'); //音声保存先パス
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}

//index
function index($app){
	
	if(isset($_SESSION['MA10_id']) && $_SESSION['MA10_time'] +3600 >time()){
		$app -> redirect(ROOT_DIR."app/mypage");
		exit();
	}
	$app->render('index.php');
}
///mypage
function mypage($app){
	
	if(isLogin($app,"app/") && !empty($_GET['created'])){
		//projectが作られた時の変数
	}
	if(!empty($_POST)){
		if(!empty($_POST['project_name'])&&!empty($_POST['scene'])&&!empty($_POST['recordtime'])){
			$Project = new Project();
			list($pin,$project_id) = $Project->create_project($_SESSION['MA10_id'],$_POST['project_name'],$_POST['scene'],$_POST['recordtime']);
			$url = ROOT_DIR."app/mypage?created=true&pin=".h($pin)."&project_id=".h($project_id)."&recordtime=".h($_POST['recordtime']);
			$app -> redirect($url);
		}else{
			$error_message = '記入漏れがあります。';
		}
	}
	$member_name = getUsername($_SESSION['MA10_id']);
	$projects = get_projects($_SESSION['MA10_id']);
	$app->render('mypage.php', array('projects'=> $projects,'target_name'=>$target_name,'member_name'=>$member_name,'error_message'=>$error_message));
}
function get_projects($member_id){
	$Project = new Project();
	$return = $Project->get_projects($member_id);
	return $return;
}

function getUsername($id){
	$Member = new Member($id);
	$return = $Member->getMember();
	return $return['username'];
}
// mypage/:id
function projectDetail($app,$id){
	
	isLogin($app,"app/");
	if(!empty($_POST['result_modify'])){ //順番が変更された
		$result_array = explode(',', $_POST['result_modify']);
		$result_serialize = serialize($result_array);
		set_voice_order($result_serialize,$id);
	}
	if(!empty($_POST['result_datetime'])){ //時間が変更された
		$send_time = $_POST['result_datetime'];
		set_send_time($send_time,$id);
	}
	if(!empty($_POST['result_datetime']) || !empty($_POST['result_modify'])){
		$app -> redirect(ROOT_DIR."app/mypage/".$id."?modified=true");
	}
	if($_GET['modified']){ //変更ー＞一旦リダイレクト　更新しても２重登録されない！
		$modified = true;
	}
	$member_name = getUsername($_SESSION['MA10_id']);
	$project = get_projectDetail($id);
	$voices = get_voices($id,$voice_order);
	$app->render('projectDetail.php', array('member_name'=>$member_name,'project'=> $project,'voices'=>$voices,'modified'=>$modified));

}
function get_voices($project_id){
	$Project = new Project($project_id);
	return $Project->get_voices();
}
function get_projectDetail($id){
	$Project = new Project($id);
	return $Project->get_projectDetail();
}
function set_voice_order($result_serialize,$project_id){ 
	$Project = new Project($project_id);
	$Project->set_voice_order($result_serialize);
}
function set_send_time($send_time,$project_id){ 
	$Project = new Project($project_id);
	$Project->set_send_time($send_time);
}
function execute_project($project_id){ // 未使用!!!
	$Project = new Project($project_id);
	$returns = $Project->get_voices();
	$a = array();
	foreach ($returns as $return){
		$a[] = VOICE_URL.$return['voice'];
	}
	list($wav_path,$playtime) = connect_all_wav($a);
	$Project->set_comp_voice($wav_path,$playtime);
	//$Project->change_status(3);//実行待ち状態
	
	return array($wav_path,$playtime);
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
	//print $wav_path."\n";

	//音声再選時間取得
	$getID3 = new getID3();
	$info = $getID3->analyze($wav_path);
	$playtime = $info["playtime_seconds"];
	$wav_httpPath = ROOT_DIR."app/models/voices/".$filename;

	$results[] = $wav_httpPath; //保存先パス
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

//account
function account($app){
	
	if(isLogin($app,"app/")){
		$member_name = getUsername($_SESSION['MA10_id']);
		$app->render('account.php',array('member_name'=>$member_name));
	}
	
}
//logout
function logout($app){
	$_SESSION = array();
	session_destroy();
	$app -> redirect(ROOT_DIR."app/");

}
//login
function login($app){
	$Member = new Member();
	$app->render('login.php',array('Member'=>$Member));
}
//signup
function signup($app){
	$Member = new Member();
	$app->render('signup.php',array('Member'=>$Member));
}
?>