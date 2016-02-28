<?php

$api_key = "aA99r87lSTtkLyRL";
$project_id = "9914";

$url = "https://api.hackaday.io/v1/projects/".$project_id."/logs?api_key=".$api_key;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);

?>