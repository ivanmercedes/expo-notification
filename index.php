<?php

require_once 'vendor/autoload.php';

use ExpoSDK\Expo;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Allow-Origin");

$log = new Logger('name');
$log->pushHandler(new StreamHandler('./logs/'.date('Y-m-d').'.log', Level::Info));

$input = file_get_contents('php://input');
$body = json_decode($input, true);
$log->info($input);

$messages = [
    [
        'title' => $body['title'],
        'to' => $body['to'],
        'body' => $body['body'],
        'data' => $body['data'],
        'sound' => 'default'
    ],
];

(new Expo)->send($messages)->push();
