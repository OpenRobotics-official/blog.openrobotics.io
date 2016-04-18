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
	//Prise en charge des guillemets dans les logs
	$startBalise = strpos($html, "body\":\"");
	$endBalise = strpos($html, "\",\"category", $startBalise);
	$readyToConvert = ($startBalise === FALSE);
	$startBalise += strlen("body\":\"");
	while(!$readyToConvert) {
		$miniStr = substr($html, $startBalise, $endBalise - $startBalise);
		$miniStr = str_replace('"', '\"', $miniStr);
		if(strlen($miniStr) > 200) {
			$miniStr = substr($miniStr, 0, 196);
			$miniStr .= "...";
		}
		$html = substr_replace($html, $miniStr, $startBalise, $endBalise - $startBalise);
		//Get next string
		$startBalise = strpos($html, "body\":\"", $startBalise + 1);
		$endBalise = strpos($html, "\",\"category", $startBalise);
		$readyToConvert = ($startBalise === FALSE);
		$startBalise += strlen("body\":\"");
	}
	$dataJson = json_decode($html, true);
	unset($url, $html, $ch);
}
$res = "	<ul id=\"HADFeed\">\n	<div id=\"HADHead\"><img src=\"./img/h.png\" width=\"100\" height=\"100\"></div>\n";
if(!empty($dataJson['logs'])) {
	foreach ($dataJson['logs'] as $log) {
	$logLink = "https://hackaday.io/project/".$log['project_id'].'/log/'.$log['id'];
	$res.= "		<li class=\"logHAD\"><div class=\"HADLogHead\"><a class=\"HADLogLink\" href=\"$logLink\"><div class=\"HADTitle\">".$log['title']."</div><div class=\"HADTimestamp\">".gmdate("d-m H:i:s ", $log['created'])."</div></a></div><div class=\"bas\"></div><div class=\"HADBody\">".$log['body']."</div></li>\n";
	}
}
$res .= "	</ul>\n";
return $res;

?>