<?php

/**
 * Ce script a pour but d'aller récupérer via l'API de Hackaday les posts de OpenRobotics afin de les afficher sur notre site web.
 * @author	Cyrille Benoit <cyrillebenoitpro@gmail.com>
 * @copyright	© 2016, OpenRobotics
 */

$api_key = "aA99r87lSTtkLyRL";
$project_id = "9914";


//Récupération des logs du projet au format JSON via cURL
{
	$url = "https://api.hackaday.io/v1/projects/".$project_id."/logs?api_key=".$api_key;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_ENCODING, "");
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$html = curl_exec($ch);
	curl_close($ch);

	//Prise en charge des caractères accentués et suppression des balises HTML (<p> </p> du body notemment)
	$html = htmlspecialchars_decode($html);
	$html = html_entity_decode($html);
	$html = strip_tags($html);

	$dataJson = json_decode($html, true);
	unset($url, $html, $ch);
}
//print_r($dataJson);die;
$res = "	<ul id=\"HADFeed\">\n	<div id=\"HADHead\"><img src=\"images/hackaday-round.png\" width=\"100\" height=\"100\"></div>\n";
if(!empty($dataJson['logs'])) {
	foreach ($dataJson['logs'] as $log) {
	$logLink = "https://hackaday.io/project/".$log['project_id'].'/log/'.$log['id'];
	$res.= "		<li class=\"logHAD\"><a class=\"HADLogLink\" href=\"$logLink\"><div class=\"HADTimestamp\">".gmdate("d-m H:i:s ", $log['created'])."</div><div class=\"HADTitle\">".$log['title']."</div></a><div class=\"HADBody\">".$log['body']."</div></li>\n";
	}
}
$res .= "	</ul>\n";
return $res;

?>