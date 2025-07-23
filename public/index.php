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

Flight::route('POST /contact-send', function () {
    $request = Flight::request();
    $name = $request->data['name'];
    $email = $request->data['email'];
    $message = $request->data['message'];
    $fruit = $request->data['fruit'];

    if ($fruit !== '') {
        exit('Thank you for your message!');
    }

    $errors = [];

    if ($name === '') {
        $errors[] = "Name can not be empty.";
    }

    if ($email === '') {
        $errors[] = "Email can not be empty.";
    }

    if ($message === '') {
        $errors[] = "Message can not be empty.";
    }

    if (strlen($name) > 50) {
        $errors[] = "Name can not be more than 50 characters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address.";
    }

    if (strlen($message) > 500) {
        $errors[] = "Message can not be more than 500 characters.";
    }

    if (count($errors) > 0) {
        var_dump($errors);
        exit("Invalid form data");
    }

    echo "OK ";

    exit("Thank you for your message!");

    Flight::redirect('/');
});

Flight::start();
