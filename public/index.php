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
        "siteTitle" => $siteInfo["tagline"],
        "keywords" => $siteInfo["keywords"],
        "siteUrl" => $siteInfo["siteUrl"],
        "pageTitle" => "Home",
        "github" => $siteInfo["github"],
        "projects" => $projects
    ]);
});

Flight::route("/contact", function () {
    $siteInfo = Flight::siteInfo();

    Flight::view()->render("contact.latte", [
        "siteOwner" =>  $siteInfo["owner"],
        "siteTitle" => $siteInfo["tagline"],
        "keywords" => $siteInfo["keywords"],
        "siteUrl" => $siteInfo["siteUrl"],
        "pageTitle" => "Contact",
        "github" => $siteInfo["github"]
    ]);
});

Flight::start();
