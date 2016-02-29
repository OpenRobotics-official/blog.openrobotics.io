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
</head>
<body>\n";
$finalString.=include("loadFromHackaday.php");
$finalString.=include("loadFromTwitter.php");
$finalString.="</body></html>";

$newHtml = fopen("newsfeed.html", "w") or die("Unable to open file!");
fwrite($newHtml, $finalString);
fclose($newHtml);
echo "newsfeed.html successfully updated.";
?>