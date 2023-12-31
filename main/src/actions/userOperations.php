<?php 

session_start();
include 'dbh.php';

class userOperations extends db {

    public function unfriendUser() {
		
		$friendUid = $_POST['friendUid'];
		$myUid = $_SESSION['UID'];
		$friends = count(json_decode($_POST['friends'], true))-1;


		$query = db::mconnect("usr_".$friendUid)->prepare("SELECT COUNT(*) as count FROM `friends`");
		$query->execute();
		
		$friend_count_friend = (int)($query->fetch()['count'][0])-1;

		$dbm = "usr_".$myUid;
		$dbf = "usr_".$friendUid;

		try {

			$query = db::pconnect()->prepare("UPDATE `users` SET `friend_count`='$friends' WHERE `uid`='$myUid'");
			$query->execute();

			$query = db::pconnect()->prepare("UPDATE `users` SET `friend_count`='$friend_count_friend' WHERE `uid`='$friendUid'");
			$query->execute();

			$query = db::mconnect($dbm)->prepare("DELETE FROM `friends` WHERE `uid`='$friendUid'");
			$query->execute();

			$query = db::mconnect($dbf)->prepare("DELETE FROM `friends` WHERE `uid`='$myUid'");
			$query->execute();

			return 1;

		}
		catch(\Exception $e) {
			return $e->getMessage();
		}

	}

    public function updateUser() {
		$which = $_POST['which'];
		$uid=$_SESSION['UID'];

		$query = "";
		// general
		if($which=='general') {
			$username = stripslashes(strip_tags($_POST['username']));
			$bio = stripslashes(strip_tags($_POST['bio']));
			$birthday = $_POST['birthday'];
			$toupdateusername = $_POST['toupdateusername'];

			try {

				if($toupdateusername=='1') {

					if($username!=$_SESSION['username']) {
						$query = db::pconnect()->prepare("UPDATE `users` SET `username`='$username' WHERE uid='$uid'");
						$query->execute();
					}

					$_SESSION['username'] = $username;

				}

				if($bio!=$_SESSION['bio']) {
					$query = db::pconnect()->prepare("UPDATE `users` SET `bio`='$bio' WHERE uid='$uid'");
					$query->execute();
					$_SESSION['bio'] = $bio;
				}

				if($bio!=$_SESSION['birthday']) {
					$query = db::pconnect()->prepare("UPDATE `users` SET `birthday`='$birthday' WHERE uid='$uid'");
					$query->execute();
					$_SESSION['birthday'] = $birthday;
				}

				return $toupdateusername;

			}catch(PDOException $e) {
				return $e->getMessage();
			}

		}
		// social
		else if($which=='social'){

			$social = json_decode($_SESSION['socialmedia'], true);

			$facebook_curr = $social["facebook"];
			$twitter_curr = $social['twitter'];
			$instagram_curr = $social['instagram'];

			$facebook = $_POST['facebook'];
			$twitter = $_POST['twitter'];
			$instagram = $_POST['instagram'];

			$socialmedia_new = array("facebook"=>"", "twitter"=>"", "instagram"=>""); 

			if(filter_var($facebook, FILTER_VALIDATE_URL))  {
				if($facebook!=$facebook_curr) {
					$socialmedia_new["facebook"] = $facebook;
				}
				else {
					$socialmedia_new["facebook"] = "-";	
				}

			}
			else {
				$socialmedia_new["facebook"] = "-";	
			}

			if(filter_var($twitter, FILTER_VALIDATE_URL))  {
				if($twitter!=$twitter_curr) {
					$socialmedia_new["twitter"] = $twitter;	
				}
				else {
					$socialmedia_new["twitter"] = "-";
				}
			}
			else {
				$socialmedia_new["twitter"] = "-";
			}

			if(filter_var($instagram, FILTER_VALIDATE_URL))  {
				if($instagram!=$instagram_curr) {
					$socialmedia_new["instagram"] = $instagram;
				}
				else {
					$socialmedia_new["instagram"] = "-";
				}
			}
			else {
				$socialmedia_new["instagram"] = "-";
			}

			$socialmedia_new = json_encode($socialmedia_new, JSON_UNESCAPED_SLASHES);
			$_SESSION['socialmedia'] = $socialmedia_new;

			try {
				$query = db::pconnect()->prepare("UPDATE `users` SET socialmedia='$socialmedia_new' WHERE `uid`='$uid'");
				$query->execute();
				return '1';
			}
			catch(PDOException $e) {
				return $e->getMessage();
			}

		}	
		// security
		else if($which=='security') {

			$current = md5(stripslashes($_POST['current']));
			$new = md5(stripslashes($_POST['new']));

			if($current==$_SESSION['password']) {
				try {
					$query = db::pconnect()->prepare("UPDATE `users` SET password='$new' WHERE `uid`='$uid'");
					$query->execute();
					$_SESSION['password'] = $new;
					return '1';
				}
				catch(PDOException $e) {
					return $e->getMessage();
				}
			}
			else {
				return 'no';
			}

		}

	}

    public function updateChatId() {
		$id = $_POST['chatid'];
		$uid = $_SESSION['UID'];

		$query = db::pconnect()->prepare("UPDATE `users` SET `chatid`='$id' WHERE `uid`='$uid'");
		$query->execute();

		$_SESSION['chatid'] = $id;

	}

	public function getUserDetails() {
		$uid = $_SESSION['UID'];

		$state = $_POST['state'];

		if($state=='enabled') {
			$la = date("Y-m-d H:i:s", strtotime(date('h:i:sa')));
			$query = db::pconnect()->prepare("UPDATE `users` SET `last_activity`='$la' WHERE `uid`='$uid'");
			$query->execute();
		}

		$dbn = "usr_".$uid;
		$query = db::mconnect($dbn)->prepare("SELECT uid FROM `friends`");
		$query->execute();
		
		$friends = array();
		while($row=$query->fetch(PDO::FETCH_ASSOC)) {
			array_push($friends, $row['uid']);
		}
		$friends = json_encode($friends);

		$query = db::mconnect($dbn)->prepare("SELECT PID as pid FROM `mypages`");
		$query->execute();

		$mypagesarr = array();

		while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
			array_push($mypagesarr, $row['pid']);
		}


		$query = db::mconnect($dbn)->prepare("SELECT pid as pid FROM `pagesfollowing`");
		$query->execute();
		
		$pagesfollowingarr = array();

		while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
			array_push($pagesfollowingarr, $row['pid']);
		}		

		$pagesfollowingarr = json_encode($pagesfollowingarr);
		$mypagesarr = json_encode($mypagesarr);

		$query = db::mconnect($dbn)->prepare("SELECT * FROM `notifications`");
		$query->execute();
		$rows = $query->rowCount();

		$array = array("noti_count"=>$rows, "friends"=>$friends, "mypagesarr"=>$mypagesarr, "pagesfollowing"=>$pagesfollowingarr);
		$json = json_encode($array);

		return $json;
	}

	public function getMyFriends() {

		if(is_null($_POST['friends']) OR empty($_POST['friends']) OR strtolower($_POST['friends'])=='null' OR count(json_decode($_POST['friends']))==0) {
			?>
			
			<center><span style="color: gray;font-size: 13px;position: relative;top: 10px;margin: 0 auto;">You do not have any friends currently.</span></center>

			<?php
		}
		else {

			$friends = json_decode($_POST['friends'], true);
			$offset = $_POST['offset'];

			$nfriends = array();
			$counter = 0;

			for($i=$offset;$i<=count($friends)-1;$i++) {
				if($counter<=10) {
					$counter++;
					array_push($nfriends, $friends[$i]);
				}
				else {
					exit;
				}
				
			}

			$offset += 10;

			$imp = "'".implode("', '", $nfriends)."'";
			$query = db::pconnect()->prepare("SELECT pic, username, fullname, uid FROM `users` WHERE `uid` IN(".$imp.")");
			$query->execute();

			while($row=$query->fetch(PDO::FETCH_ASSOC)) {
				$username= $row['username'];
				$uid = $row['uid'];
				$fullname = $row['fullname'];
				$dp = $row['pic'];

				?>
				
				<div class="friends_item" id="id<?php echo $username; ?>"><div class="dp"><img src="/data/img_users/<?php echo $dp; ?>" alt=""></div><div class="details"><div class="username"><span><?php echo $username; ?></span></div><div class="fullname"><span><?php echo $username; ?></span></div></div><div class="action"><i class="fas fa-times" onclick="unfriendUser('<?php echo $uid; ?>', '<?php echo $username; ?>');" style="color: #333;font-size: 18px;cursor: pointer;"></i></div><div class="spinner loader"></div><button class="unfriend_confirm" id="btn">Unfriended &#10004;</button></div>
				

				<?php

			}

			if(count($friends)-$offset>0) {
				?>
				
				<br>
				<center><span style="text-decoration: underline;color: blue;font-size: 13px;cursor: pointer;" onclick="loadfriends('<?php echo $offset; ?>', '1')">Load More</span></center>
				
				<?php
			}

		}

	}

}

$obj = new userOperations;

if(isset($_GET['action']) && !empty($_GET['action'])) {
    
    $act = $_GET['action'];
    if($act=='unfriend') {
        echo $obj->unfriendUser(); 
    } 
    else if($act=='update-user') {
        echo $obj->updateUser(); 
    }
    else if($act=='update-chatid') {
        echo $obj->updateChatId(); 
    }
    else if($act=='get-user-details') {
        echo $obj->getUserDetails(); 
    }
    else if($act=='get-my-friends') {
        echo $obj->getMyFriends(); 
    }
    else {
        header('Location: ../../notfound.html');
    }

} else {
    header('Location: ../../notfound.html');
}