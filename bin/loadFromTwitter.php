<?php

/**
 * Ce script a pour but d'aller récupérer via l'API de Twitter les posts à propos de #OpenRobotics afin de les afficher sur notre site web.
 * @author	Cyrille Benoit <cyrillebenoitpro@gmail.com>
 * @copyright	© 2016, OpenRobotics
 */

require "./twitteroauth/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;


$connection = new TwitterOAuth("kE2x4pQ9dHFvEs76NEoWgqYDE", "2CsCehBPh5T88pnn932JvLx2t6OOlXpguXMxgIe9x1hPEsLvgl", "2220296553-uvjS7VSicVSd7xHlvCeALSvN0v1XM5VWUj2LbXq", "6MkED9UcFPVXV6i6TeEplBrGQXBzPCmUpUAcI804kbT7M");

$content = $connection->get("search/tweets", array("q"=>urlencode("#OpenRobotics")));

if(!empty($content['statuses'])) {
	foreach ($content['statuses'] as $statut) {
	print("<class=\"TwitterTimestamp\">".gmdate("d-m H:i:s :", strtotime($statut['created_at']))."</class><img class=\"TwitterPicture\" src=".$statut['user']['profile_image_url']."></class><class=\"TwitterBody\">".$statut['text']."</class>\n");
	}
}

?>