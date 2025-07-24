<?php

use App\FlashMiddleware;
use App\Mailer;

require_once __DIR__ . "/../functions.php";

Flight::map('projects', function () {
    $file = __DIR__ . '/../../data/projects.json';
    return json_decode(file_get_contents($file), true);
});

Flight::map('siteInfo', function () {
    $file = __DIR__ . '/../../data/site.json';
    return json_decode(file_get_contents($file), true);
});

Flight::group('', function () {
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
            "projects" => $projects,
            "flash" => Flight::get('flash')
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
            "github" => $siteInfo["github"],
            "flash" => Flight::get('flash')
        ]);
    });
}, [new FlashMiddleware()]);

Flight::route('POST /contact-send', function () {
    $request = Flight::request();
    $name = $request->data['name'];
    $email = $request->data['email'];
    $message = htmlentities($request->data['message']);
    $fruit = $request->data['fruit'];

    // If $fruit has been filled out we are likely dealing with a bot so then we exit.
    if ($fruit !== '') {
        exit('Thank you for your message!');
    }

    $errors = getFormErrors($name, $email, $message);

    if (count($errors) > 0) {
        setFlash('Invalid form data.', 'error');
        Flight::redirect('/contact');
        exit();
    }

    $siteInfo = Flight::siteInfo();
    $receiver = $siteInfo['email'];
    $fromEmail = $siteInfo['fromEmail'];
    $subject = "New submission of contact form.";

    $mailer = new Mailer();
    $mailer->send($receiver, $subject, $message, $fromEmail);

    setFlash('Thank you for your message!', 'success');

    Flight::redirect('/');
});
