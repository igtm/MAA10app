<?php 
session_start();
require dirname(__FILE__).'/../lib/Slim/Slim.php';
require dirname(__FILE__).'/controllers/controller.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->config('templates.path','templates');
$app->contentType('text/html; charset=utf-8');

$app->get('/', function () use($app) {
	index($app);
});

$app->map('/mypage', function () use($app) {
	mypage($app);
})->via('GET', 'POST');

$app->map('/mypage/:id', function ($id) use($app) {
	projectDetail($app,$id);
})->via('GET', 'POST');

$app->map('/account', function () use($app) {
	account($app);
})->via('GET', 'POST');

$app->get('/logout', function () use($app) {
	logout($app);
});

$app->map('/login', function () use($app) {
	login($app);
})->via('GET', 'POST');

$app->map('/signup', function () use($app) {
	signup($app);
})->via('GET', 'POST');

$app->run();
?>