<?php

include '../actions/dbh.php';
session_start();

class friendRequests extends db {

	public function getFriendRequests() {
		$uid = $_SESSION['UID'];
		$myDB = "usr_".$uid;
		$friend_reqs = array();

		$offset = $_POST['offset'];
		$lim = $offset+6;

		$querymc = db::mconnect($myDB)->prepare("SELECT uid FROM `friend_requests` LIMIT $offset, $lim");
		$querymc->execute();
		$offset += 6;

		$html = "";

		if($querymc->rowCount()<=0) {
			return "<span style='position: absolute;top: 10px;left: 50%;color: gray;font-size: 13px;transform: translate(-50%, 0);'>No Friend Requests.</span>";
		}
		else {
			
			while($row=$querymc->fetch(PDO::FETCH_ASSOC)) {
				array_push($friend_reqs, $row['uid']);
			}

		if(count($friend_reqs)>0) {

			$nfriend_reqs = "'".implode("', '", $friend_reqs)."'";
			
			$query = db::pconnect()->prepare("SELECT pic, uid, username, fullname FROM `users` WHERE `uid` IN (".$nfriend_reqs.")");
			$query->execute();

			while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
				$freqs[$row['uid']] = array($row['pic'], $row['username'], $row['fullname']);
			}

			foreach($freqs as $key => $val) {

				$img = $freqs[$key][0];
				$username = $freqs[$key][1];
				$fullname = $freqs[$key][2];

				$split = str_split(strtolower($fullname));

				$id = uniqid('').rand(0, 9900).$split[0].$split[1];

				?>

					<div class='freq-items' id='freq-items_<?php echo $id ?>'>

						<button type='button' onclick='accept_request("<?php echo $key; ?>", "<?php echo $id; ?>")' id='accept_request'>Accept</button>

						<div class='dp'>

							<img src='data/img_users/<?php echo $img; ?>' alt=''>

						</div>

						<div class='user_details'>
							
							<div class='top_name'><span><?php echo $username; ?></span></div>

							<div class='bottom_name'><span><?php echo $fullname; ?></span></div>

						</div>

						<button type='button' onclick='decline_request("<?php echo $key; ?>", "<?php echo $id; ?>");' id='decline_request'>Decline</button>

						<div class='overlay_freq' id='overlay_<?php echo $id; ?>'>
							<div class='spinner_freq loader'></div>
						</div>

					</div>

					<?php 

					if($querymc->rowCount()>$lim) {
						?>

						<br>
						<center><span style="color: blue;text-decoration: underline;font-size: 13px;" onclick="load_freq(<?php echo $offset; ?>, '1');">Load More</span></center>						

						<?php
					}

			}

		}
		else {
			return "<span style='position: absolute;top: 10px;left: 50%;color: gray;font-size: 13px;transform: translate(-50%, 0);'>No Friend Requests.</span>";
		}

		}

	}

	public function friendRequestAction($action) {
		if($action=='accept') {

			$uidFriend = $_POST['friendUid']; 
			$uidMy = $_SESSION['UID'];
			
			$myDB = "usr_".$uidMy;
			$friendDB = "usr_".$uidFriend;

			try {

				$myDBc = db::mconnect($myDB);

				// $query = $myDBc->prepare("SELECT COUNT(*) as count FROM `friends`");
				// $query->execute();
				// $countm = (int)($query->fetch()['count'][0])+1;

				$query = $myDBc->prepare("DELETE FROM `friend_requests` WHERE `uid`='$uidFriend'");
				$query->execute();

				$query = db::pconnect()->prepare("UPDATE `users` SET `friend_count`=`friend_count`+1 WHERE uid='$uidMy'");	
				$query->execute();

				$query = $myDBc->prepare("INSERT INTO `friends`(`uid`) VALUES('$uidFriend')");
				$query->execute();



				$friendDBc = db::mconnect($friendDB);

				// $query = $friendDBc->prepare("SELECT COUNT(*) as count FROM `friends`");
				// $query->execute();
				// $countf = (int)($query->fetch()['count'][0])+1;
				
				$query = $friendDBc->prepare("DELETE FROM `friend_requests_sent` WHERE `uid`='$uidMy'");
				$query->execute();

				$query = db::pconnect()->prepare("UPDATE `users` SET `friend_count`=`friend_count`+1 WHERE uid='$uidFriend'");	
				$query->execute();
				
				$query = $friendDBc->prepare("INSERT INTO `friends`(`uid`) VALUES('$uidMy')");
				$query->execute();

				return 1;

			}
			catch(\Exception $e) {
				return $e->getMessage();
			}

			// ----------------

		}
		else {

			$uidFriend = $_POST['key'];
			$uidMy = $_SESSION['UID'];
			$myDB = "usr_".$uidMy;
			$friendDB = "usr_".$uidFriend;

			try {

				$query = db::mconnect($myDB)->prepare("DELETE FROM `friend_requests` WHERE `uid`='$uidFriend'");
				$query->execute();

				$query = db::mconnect($friendDB)->prepare("DELETE FROM `friend_requests_sent` WHERE `uid`='$uidMy'");
				$query->execute();
		
				return 1;

			}
			catch(\Exception $e) {
				return $e->getMessage();
			}

		}
	}

	public function sendFriendRequest() {
		$friendUid = $_POST['frienduid'];
		$myUid = $_SESSION['UID'];

		$friendDB = "usr_".$friendUid;
		$myDB = "usr_".$myUid;

		$query = db::mconnect($myDB)->prepare("SELECT uid FROM `friend_requests_sent` WHERE `uid`='$friendUid'");
		$query->execute();

		if($friendUid==$myUid) {
			return 3; // sending request to myself
		}
		else {

			if($query->rowCount()>0) {
				return 2;
			}
			else {

				try {

					$query = db::mconnect($myDB)->prepare("INSERT INTO `friend_requests_sent`(uid) VALUES('$friendUid')");
					$query->execute();

					$query = db::mconnect($friendDB)->prepare("INSERT INTO `friend_requests`(uid) VALUES('$myUid')");
					$query->execute();

					return 1;

				}
				catch(PDOException $e) {
					return $e->getMessage();
				}

			}
		
		}

	}

    public function getFriendRequestsCount() {
        $dbname = "usr_".$_SESSION['UID'];
		$query = db::mconnect($dbname)->prepare("SELECT COUNT(*) as count FROM `friend_requests`");
		$query->execute();

		$f_req_count = $query->fetch(PDO::FETCH_ASSOC)['count'];

		return $f_req_count;
    }

}

$obj = new friendRequests;
if($_GET['action']=='getFriendRequests') {
	echo $obj->getFriendRequests();
}
else if($_GET['action']=='accept' OR $_GET['action']=='decline') {
	echo $obj->friendRequestAction($_GET['action']);
} 
else if($_GET['action']=='sendRequest') {
	echo $obj->sendFriendRequest();
}
else if($_GET['action']=='getFriendRequestsCount') {
    echo $obj->getFriendRequestsCount();
}else {
    echo "1";
}