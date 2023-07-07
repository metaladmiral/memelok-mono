<?php 

session_start();
include './dbh.php';

$uid = $_SESSION['UID'];
$dbname = "usr_".$_SESSION['UID'];

$db = new Db;

$query = $db->mconnect($dbname)->prepare("SELECT COUNT(*) as count FROM `notifications`");
$query->execute();
$fetch = $query->fetch()['count'];

$server = $_SERVER['SERVER_NAME'];

/* ------------- */ 

$query = $db->mconnect($dbname)->prepare("SELECT pid as pid FROM `pagesfollowing`");
$query->execute();

$pagesfollowingarr = array();

while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
	array_push($pagesfollowingarr, $row['pid']);
}		

$pagesfollowingarr = json_encode($pagesfollowingarr);
$_SESSION['pagesfollowingarr'] = $pagesfollowingarr;
/* ------------ */

$query = $db->mconnect($dbname)->prepare("SELECT PID as pid FROM `mypages`");
$query->execute();

$mypagesarr = array();

while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
	array_push($mypagesarr, $row['pid']);
}		

$mypagesarr = json_encode($mypagesarr);
$_SESSION['mypagesarr'] = $mypagesarr;

/* getfreques */
/*

*/
/* updatesessidquery */

$sessid = $_COOKIE['PSID'];

$upquery = $db->pconnect()->prepare("UPDATE `users` SET `sessid`='$sessid' WHERE `uid`='$uid'");
$upquery->execute();

?>

<script>
	
	localStorage.setItem('noti_count', '<?php echo $fetch; ?>');
	localStorage.setItem('pagesfollowing', '<?php echo $pagesfollowingarr; ?>');
	localStorage.setItem('mypagesarr', '<?php echo $mypagesarr; ?>');
	localStorage.setItem('uid', '<?php echo $_SESSION['UID'] ?>');
	/*localStorage.setItem('f_req_count', '<?php echo $f_req_count; ?>');*/
	
	window.location = "http://<?php echo $server; ?>/";

</script>