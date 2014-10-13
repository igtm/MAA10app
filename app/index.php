<?php 
require dirname(__FILE__).'/../lib/Slim/Slim.php';
require dirname(__FILE__).'/models/model.php';
function h($value){return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->config('templates.path','templates');
$app->contentType('text/html; charset=utf-8');

$app->get('/', function () use($app) {
	$authPear = get_auth_pear();
	if($authPear->getAuth()){
		$app -> redirect("/API/MAA10app/app/mypage");
		exit();
	}
	$app->render('index.php');
});

$app->get('/mypage', function () use($app) {
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect("/API/MAA10app/app/");
		exit();
	}elseif($_GET['created']){
		$target_name = get_targetName(h($_GET['target_id']));
		$member_name = $authPear->getUsername();
	}
	$projects = get_projects($authPear->getAuthData('id'));
	$app->render('mypage.php', array('authPear'=>$authPear,'projects'=> $projects,'target_name'=>$target_name,'member_name'=>$member_name));
});
$app->map('/mypage/createProject', function () use($app) {
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect("/API/MAA10app/app/");
		exit();
	}elseif(!empty($_POST)){
		if(!empty($_POST['project_name'])&&!empty($_POST['target_name'])&&!empty($_POST['phone'])){
			list($pin,$project_id,$target_id) = create_project($_POST,$authPear->getAuthData('id'));
			$url = "/API/MAA10app/app/mypage?created=true&pin=".h($pin)."&project_id=".h($project_id)."&target_id=".h($target_id);
			$app -> redirect($url);
		}else{
			$error_message = '記入漏れがあります。';
		}
	}
	$app->render('createProject.php', array('authPear'=>$authPear,'error_message'=>$error_message));
})->via('GET', 'POST');
$app->get('/mypage/:id', function ($id) use($app) {
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect("/API/MAA10app/app/");
		exit();
	}
	$project = get_projectDetail($id);
	$app->render('projectDetail.php', array('authPear'=>$authPear,'project'=> $project));
});
$app->map('/account', function () use($app) {
	$authPear = get_auth_pear();
	if(!$authPear->getAuth()){
		$app -> redirect("/API/MAA10app/app/");
		exit();
	}
	$app->render('account.php',array('authPear'=>$authPear));
})->via('GET', 'POST');


$app->get('/logout', function () use($app) {
	$authPear = get_auth_pear();
	$authPear -> logout();
	$authPear -> start();
	$app -> redirect("/API/MAA10app/app/");
});

$app->map('/login', function () use($app) {
	$authPear = get_auth_pear();
	$app->render('login.php',array('authPear'=>$authPear));
})->via('GET', 'POST');
$app->map('/signup', function () use($app) {
	$authPear = get_auth_pear();
	$app->render('signup.php',array('authPear'=>$authPear));
})->via('GET', 'POST');





$app->run();
?>