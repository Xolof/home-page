<?php
require "../vendor/autoload.php";

use Latte\Engine;

Flight::register("view", Engine::class, [], function ($latte) {
    $latte->setTempDirectory(__DIR__ . '/../cache/');
    $latte->setLoader(new \Latte\Loaders\FileLoader(__DIR__ . '/../app/views/'));
});

Flight::map('projects', function () {
   $file = __DIR__ . '/../data/projects.json';
   return json_decode(file_get_contents($file), true);
});

Flight::map('siteInfo', function () {
   $file = __DIR__ . '/../data/site.json';
   return json_decode(file_get_contents($file), true);
});

Flight::route("/", function () {
  $projects = Flight::projects();
  $siteInfo = Flight::siteInfo();

  Flight::view()->render("home.latte", [
    "siteOwner" =>  $siteInfo["owner"],
    "siteTitle" =>  $siteInfo["owner"] . " | " . $siteInfo["tagline"],
    "pageTitle" => "Home",
    "github" => $siteInfo["github"],
    "projects" => $projects]);
});

Flight::start();

