<?php 
require '../lib/Slim/Slim.php';
require 'models/model.php';
session_cache_limiter(false);
session_start();


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
	$project = get_projectDetail($id);
	$app->render('projectDetail.php', array('project'=> $project));
});
$app->get('/signup', function () use($app) {
	$app->render('signup.php');
});
$app->get('/logout', function () use($app) {
	$app->render('logout.php');
});
$app->get('/login', function () use($app) {
	$authPear = get_auth_pear();
	$app->render('login.php',array('authPear'=>$authPear));
});

$app->run();
?>