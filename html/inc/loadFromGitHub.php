<?php

/**
 * Ce script a pour but d'aller récupérer via l'API de GitHub les commits de tous les projets de l'organisation OpenRobotics-Official afin de les afficher sur notre site web.
 * @author	Cyrille Benoit <cyrillebenoitpro@gmail.com>
 * @copyright	© 2016, OpenRobotics
 */

//Récupération des logs du projet au format JSON via cURL
{
	$url = "https://api.github.com/users/OpenRobotics-official/events";

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_ENCODING, "");
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, "Awesome-Octocat-App");
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

$formattedData = array();
if(!empty($dataJson)) {
	foreach ($dataJson as $activity) {
		if(empty($activity['payload']['commits']))
			continue;
		$commits = $activity['payload']['commits'];
		$commitMessage = "";
		foreach ($commits as $commit) {
			$commitMessage 	= $commit['message'];
			$commitLink 	= $commit['url'];
		}
		$personName 		= $activity['actor']['login'];
		$personPhotoUrl 	= $activity['actor']['avatar_url'];
		$personLink 		= $activity['actor']['url'];
		$repoName 			= $activity['repo']['name'];
		$repoLink 			= $activity['repo']['url'];
		$activityTimestamp 	= $activity['created_at'];
		$tmp = array( 'person' 		=> array(
										'name' 		=> $personName,
										'url' 		=> $personLink,
										'photoUrl' 	=> $personPhotoUrl),
					  'commit' 		=> array(
						  				'message' 	=> $commitMessage,
						  				'url'		=> $commitLink),
					  'url'	   		=> $repoLink,
					  'name'		=> $repoName,
					  'timestamp' 	=> $activityTimestamp);
		$formattedData[$repoName][] = $tmp;
		unset($personName, $personLink, $personPhotoUrl, $repoName, $repoLink, $activityTimestamp, $commitMessage, $commits);
	}
}


$res = "	<ul id=\"GHFeed\">\n	<div id=\"GHHead\"><img src=\"../img/g.png\" width=\"35%\"></div>\n";
if(!empty($formattedData)) {
	foreach ($formattedData as $project) {
		$res .= "<li class=\"projectGH\">
	<a href=\"".$project[0]['url']."\"><div class=\"titleGH\">".$project[0]['name']."</div></a>
	<ul class=\"commitList\">";
		foreach ($project as $commit) {
			$res .= "<li class=\"commitGH\">
	<div class=\"commitHead\">
		<div class=\"commitPerson\">
			<a href=\"".$commit['person']['url']."\">
				<div class=\"personPicture\"><img src=\"".$commit['person']['photoUrl']."\"></div>
				<div class=\"personName\">".$commit['person']['name']."</div>
			</a>
		</div>
		<a href=\"".$commit['commit']['url']."\">
			<div class=\"commitTimestamp\">".$commit['timestamp']."</div>
		</a>
		<div class=\"commitMessage\">".$commit['commit']['message']."</div>
	</div>
</li>";
		}
		$res.="</ul>";
	}
}
$res .= "	</ul>\n";
echo($res);die;
return $res;
?>

