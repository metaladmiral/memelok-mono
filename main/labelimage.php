<?php

$ch = curl_init();

$pgnname = $_GET['pname'];
$imagelink = $_GET['imlink'];

curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/labelimage?pname=$pgname&imlink=$imagelink");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

echo $output = curl_exec($ch);
curl_close($ch);

?>