<?php
require "../vendor/autoload.php";

use Latte\Engine;


Flight::register("view", Engine::class, [], function ($latte) {
    $latte->setTempDirectory(__DIR__ . '/../cache/');
    $latte->setLoader(new \Latte\Loaders\FileLoader(__DIR__ . '/../app/views/'));
});

Flight::route("/", function () {
  echo "Flight has taken off!";
});

Flight::start();

