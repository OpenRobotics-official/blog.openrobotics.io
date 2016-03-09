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
	<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/style.css\">
	<script src=\"./lib/js/jquery-1.12.1.min.js\"></script>
	<script type=\"text/javascript\" src=\"./js/callAPI.js\"></script>
</head>
<body>\n<div id=\"conteneur\">\n";

$finalString .= include("loadFromHackaday.php");
$finalString .= include("loadFromTwitter.php");
$finalString .= "<div class=\"bas\"></div>\n</div>\n</body></html>";

return $finalString;

?>