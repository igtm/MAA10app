<?php 
require '../lib/Slim/Slim.php';
require 'models/model.php';
session_cache_limiter(false);
session_start();

			//ログイン成功
			$_SESSION['id'] = $table['id'];
			$_SESSION['time'] = time();
			$_SESSION['college_id'] = $table['college_id'];
			
			if($_POST['save'] == 'on'){ //ログイン情報をcookieに記録する
				setcookie('email',h($_POST['email']),time()+60*60*24*14);
				setcookie('password',h($_POST['password']),time()+60*60*24*14);
			}


\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->config('templates.path','templates');


$app->get('/', function () use($app) {
	$app->render('index.php');
});
$app->get('/mypage', function () use($app) {
	$projects = get_projects();
	$app->render('mypage.php', array('projects'=> $projects));
});
$app->get('/mypage/:id', function ($id) use($app) {
	$project = show_projectDetail($id);
	$app->render('projectDetail.php', array('project'=> $project));
});
$app->get('/signup', function () use($app) {
	$app->render('signup.php');
});
$app->get('/logout', function () use($app) {
	$app->render('logout.php');
});
$app->get('/login', function () use($app) {
	$app->render('login.php');
});

$app->run();
?>