<?php 

session_start();

$server = explode('.', $_SERVER['SERVER_NAME']);
$domain = count($server)-1;
$host = count($server)-2;
$server = $server[$host].".".$server[$domain];

setcookie('PSID', "", time()-3600, "/", $server);
setcookie('LID', "", time()-3600, "/", $server);

session_destroy();

header('Location: http://'.$server.'/login');

?>