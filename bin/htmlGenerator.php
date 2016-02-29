<?php

/**
 * Ce script a pour but de construire la page HTML
 * @author	Cyrille Benoit <cyrillebenoitpro@gmail.com>
 * @copyright	© 2016, OpenRobotics
 */

$finalString = "<!DOCTYPE html>
<html>
<head>
	<title>Newsfeed</title>
	<meta charset=\"utf-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
</head>
<body>".require_once("loadFromHackaday.php").require_once("loadFromTwitter.php")."</body></html>";


$newHtml = fopen("newsfeed.html", "w") or die("Unable to open file!");
fwrite($myfile, $finalString);
fclose($myfile);

?>