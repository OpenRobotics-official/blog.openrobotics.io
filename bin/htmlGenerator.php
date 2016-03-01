<?php

/**
 * Ce script a pour but de construire la page HTML newsfeed
 * @author	Cyrille Benoit <cyrillebenoitpro@gmail.com>
 * @copyright	© 2016, OpenRobotics
 */

$finalString = "<!DOCTYPE html>
<html>
<head>
	<link rel=\"icon\" href=\"https://pbs.twimg.com/profile_images/546459220678168576/RuNJUDst.png\"/>
	<title>OR Newsfeed</title>
	<meta charset=\"utf-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">
	<script type=\"text/javascript\" src=\"isReloadNeeded.js\"></script>
	<script src=\"jquery-1.12.1.min.js\"></script>
</head>
<body onload=\"reloadOnNeed ();\">\n<div id=\"info\" style=\"width:500px; overflow:auto; background-color:#e0d0d0;\"></div>\n";

$finalString .= include("loadFromHackaday.php");
$finalString .= include("loadFromTwitter.php");
$finalString .= "</body></html>";

echo "\"$finalString\"";
/*$htmlFile = fopen("newsfeed.html", "w") or die("Unable to open file!");
fwrite($htmlFile, $finalString);
fclose($htmlFile);

echo "newsfeed.html successfully updated.";*/

?>