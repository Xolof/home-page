<?php
require "../vendor/autoload.php";

Flight::route("/", function () {
  echo "Flight has taken off!";
});

Flight::start();

