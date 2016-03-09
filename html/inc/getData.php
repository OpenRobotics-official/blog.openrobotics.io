<?php
/**
 * Ce script a pour vérifier la nécéssité de re-construire la page HTML newsfeed
 * @author	Cyrille Benoit <cyrillebenoitpro@gmail.com>
 * @copyright	© 2016, OpenRobotics
 */

//Récupération des données
{
	$dateModif = 0;
	$fileExists = false;
	if(file_exists("../newsfeed.html")) {
		$dateModif = filemtime("../newsfeed.html");
		$fileExists = true;
	}
	$dateActuelle = gettimeofday()['sec'];
}
//Si on a déjà fait une maj dans les 3 minutes et que le fichier existe
if ($fileExists && $dateActuelle-$dateModif < 3*60) {
	echo $dateActuelle-$dateModif;
	return;
}

// Sinon on crée ou met à jour le fichier
{
	//Récupération du nouveau HTML
	$finalString = include("htmlGenerator.php");
	
	$htmlFile = fopen("../newsfeed.html", "w") or die("Could not open file");
	fwrite($htmlFile, $finalString);
	fclose($htmlFile);
	touch("../newsfeed.html");
}
unset($dateModif, $dateActuelle, $fileExists, $finalString, $htmlFile);
echo '0';
return;

?>