<?php

/**
 * Ce script a pour but d'aller récupérer via l'API de Twitter les posts à propos de #OpenRobotics afin de les afficher sur notre site web.
 * @author	Cyrille Benoit <cyrillebenoitpro@gmail.com>
 * @copyright	© 2016, OpenRobotics
 */

require "../lib/twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


$connection = new TwitterOAuth("kE2x4pQ9dHFvEs76NEoWgqYDE", "2CsCehBPh5T88pnn932JvLx2t6OOlXpguXMxgIe9x1hPEsLvgl", "2220296553-uvjS7VSicVSd7xHlvCeALSvN0v1XM5VWUj2LbXq", "6MkED9UcFPVXV6i6TeEplBrGQXBzPCmUpUAcI804kbT7M");

$content = $connection->get("search/tweets", array("q"=>urlencode("#OpenRobotics")));
$content = json_decode(json_encode($content), true);

$res = "	<ul id=\"TwitterFeed\">\n	<div id=\"TwitterHead\"><img src=\"./img/hackaday-round.png\" width=\"100\" height=\"100\"></div>\n";
if(!empty($content['statuses'])) {
	foreach ($content['statuses'] as $statut) {
	$tweetLink = "https://twitter.com/".$statut['user']['screen_name'].'/status/'.$statut['id_str'];
	$res .= "		<li class=\"Tweet\"><div class=\"TweetHead\"><a class=\"TweetLink\" href=\"$tweetLink\"><img class=\"TwitterPicture\" src=".$statut['user']['profile_image_url']."><div class=\"TwitterTimestamp\">".gmdate("d-m H:i:s ", strtotime($statut['created_at']))."</div></a></div><div class=\"bas\"></div><div class=\"TwitterBody\">".$statut['text']."</div></li>\n";
	}
}
$res .= "	</ul>\n";
return $res;
?>

