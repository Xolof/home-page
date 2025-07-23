<?php

require "../vendor/autoload.php";
require_once "../app/functions.php";

use Latte\Engine;

startSession();

Flight::register("view", Engine::class, [], function ($latte) {
    $latte->setTempDirectory(__DIR__ . '/../cache/');
    $latte->setLoader(new \Latte\Loaders\FileLoader(__DIR__ . '/../app/views/'));
});

require '../app/config/routes.php';

Flight::start();
