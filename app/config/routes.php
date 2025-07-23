<?php

require_once __DIR__ . "/../functions.php";

Flight::map('projects', function () {
    $file = __DIR__ . '/../../data/projects.json';
    return json_decode(file_get_contents($file), true);
});

Flight::map('siteInfo', function () {
    $file = __DIR__ . '/../../data/site.json';
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

    // If $fruit has been filled out we are likely dealing with a bot so then we exit.
    if ($fruit !== '') {
        exit('Thank you for your message!');
    }

    $errors = getFormErrors($name, $email, $message);

    if (count($errors) > 0) {
        var_dump($errors);
        exit("Invalid form data");
    }

    echo "OK ";
    exit("Thank you for your message!");

    Flight::redirect('/');
});
