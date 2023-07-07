<?php 

session_start();
include 'dbh.php';

class pageOperations extends db {

    private function checkPageExistence($email) {

		$query = db::pageconnect()->prepare("SELECT * FROM `info` WHERE `email`='$email'");
		$query->execute();

		if($query->rowCount()>0) {
			return true;
		}
		else {
			return false;
		}

	}

	public function createPage() {
        $facebook = strip_tags($_POST['facebook']);
        $instagram = strip_tags($_POST['instagram']);
        $twitter = strip_tags($_POST['twitter']);
        $social = array("facebook" => $facebook, "instagram" => $instagram, "twitter" => $twitter);

        $name = strip_tags(stripslashes($_POST['name']));

        if (strlen($name) > 4 && strlen($name) < 19) {
            if (preg_match("/[!@^%\$()=?;+#\/*\[\]\{\}<>|,' -\"]/", $name)) {
                return "char_err";
            } else {
                $email = strip_tags(stripslashes($_POST['email']));
                $pic = $_POST['pic'];

                $_SESSION['picaasa'] = $pic;

                $creatorName = $_SESSION['username'];
                $creatorUid = $_SESSION['UID'];
                $social = json_encode($social);

                $pre = strlen($name) . strlen($email) . strlen($creatorName);
                $pid = uniqid($pre, true);
                $pid = explode('.', $pid);
                $pid = $pid[0] . rand(0, 999) . $pid[1];

                $date = date("j:n:Y");

                $about = $_POST['about'];

                if (
                    (is_null($name) || empty($name)) ||
                    (is_null($email) || empty($email)) ||
                    (is_null($facebook) || empty($facebook)) ||
                    (is_null($instagram) || empty($instagram)) ||
                    (is_null($twitter) || empty($twitter)) ||
                    (is_null($about) || empty($about))
                ) {
                    return 'err';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return 'email_err';
                } else {
                    if ($this->checkPageExistence($email) == false) {
                        if ($pic == '-' || is_null($pic) || empty($pic)) {
                            // Do nothing
                        } else {
                            $picDef = "def_" . $pic;

                            if (copy("../../data/temp_uploads/$pic", "../../data/img_pages/$picDef")) {
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/optimize-pagedp?imlink=$picDef&rname=$pic");
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                $output = curl_exec($ch);
                                curl_close($ch);
                            }
                        }

                        try {
                            $query = db::pageconnect()->prepare("INSERT INTO `info`(pid, pic, about, page_name, creator_username, creator_uid, creation_date, email, social) VALUES(:pid, :pic, :about, :pagename, :creatorusername, :creatoruid, :creatordate, :email, :social)");
                            $query->bindParam(":pid", $pid);
                            $query->bindParam(":pic", $pic);
                            $query->bindParam(":about", $about);
                            $query->bindParam(":pagename", $name);
                            $query->bindParam(":creatorusername", $creatorName);
                            $query->bindParam(":creatoruid", $creatorUid);
                            $query->bindParam(":creatordate", $date);
                            $query->bindParam(":email", $email);
                            $query->bindParam(":social", $social);

                            $query->execute();

                            $dbName = "usr_" . $creatorUid;
                            $query = db::mconnect($dbName)->prepare("INSERT INTO `mypages`(PID, p_name, p_dp) VALUES(:pid, :name, :pic)");
                            $query->bindParam(":pid", $pid);
                            $query->bindParam(":name", $name);
                            $query->bindParam(":pic", $pic);
                            $query->execute();

                            $query = db::connect()->prepare("CREATE DATABASE `pg_$pid`");
                            $query->execute();

                            $query = db::mconnect('pg_' . $pid)->prepare("CREATE TABLE `posts`(
                                id INT(20) AUTO_INCREMENT PRIMARY KEY,
                                mid VARCHAR(250) NOT NULL
                            )");
                            $query->execute();

                            $query = db::mconnect('pg_' . $pid)->prepare("CREATE TABLE `followers`(
                                id INT(20) AUTO_INCREMENT PRIMARY KEY,
                                uid VARCHAR(250) NOT NULL
                            )");
                            $query->execute();

                            return 1;
                        } catch (\Exception $e) {
                            return $e->getMessage();
                        }
                    } else {
                        return 'nemail_err';
                    }
                }
            }
        } else {
            return 'len_err';
        }
    }

	public function followStateChange($action) {
        $pid = $_POST['pid'];
        $uid = $_SESSION['UID'];

        $db = "pg_" . $pid;

        $pagesFollowingArr = json_decode($_SESSION['pagesfollowingarr'], true);

        if($action=='follow') {
            if (!in_array($pid, $pagesFollowingArr)) {
                if (!in_array($pid, json_decode($_SESSION['mypagesarr'], true))) {
                    try {
                        $query = db::mconnect($db)->prepare("INSERT INTO `followers`(uid) VALUES('$uid')");
                        $query->execute();
    
                        // $query = db::mconnect($db)->prepare("SELECT COUNT(*) as count FROM `followers`");
                        // $query->execute();
                        // $nCountFollowersPage = $query->fetch(PDO::FETCH_ASSOC)['count'];
    
                        // $query = db::pageconnect()->prepare("UPDATE `info` SET `followers`='$nCountFollowersPage' WHERE pid='$pid'");
                        // $query->execute();
                        $query = db::pageconnect()->prepare("UPDATE `info` SET `followers`=`followers`+1 WHERE pid='$pid'");
                        $query->execute();
    
                        /* ---------------- */
    
                        $myDb = db::mconnect("usr_" . $uid);
    
                        $query = $myDb->prepare("INSERT INTO `pagesfollowing`(pid) VALUES('$pid')");
                        $query->execute();
    
                        // $query = $myDb->prepare("SELECT COUNT(*) as count FROM `pagesfollowing`");
                        // $query->execute();
                        // $count = $query->fetch(PDO::FETCH_ASSOC)['count'];
    
                        // $query = db::pconnect()->prepare("UPDATE `users` SET `pages_following_count`='$count' WHERE `uid`='$uid'");
                        // $query->execute();
                        $query = db::pconnect()->prepare("UPDATE `users` SET `pages_following_count`=`pages_following_count`+1 WHERE `uid`='$uid'");
                        $query->execute();
    
                        array_push($pagesFollowingArr, $pid);
                        $pagesFollowingArr = json_encode($pagesFollowingArr);
                        $_SESSION['pagesfollowingarr'] = $pagesFollowingArr;
    
                        return 1;
                    } catch (\Exception $e) {
                        return 0;
                    }
                } else {
                    return "You cannot follow your own page.";
                }
            } else {
                return "You already follow this page.";
            }
        }
        else {
            if (in_array($pid, $pagesFollowingArr)) {
                try {
                    $query = db::mconnect($db)->prepare("DELETE FROM `followers` WHERE `uid`='$uid'");
                    $query->execute();
    
                    $query = db::pageconnect()->prepare("UPDATE `info` SET `followers`=`followers`-1 WHERE pid='$pid'");
                    $query->execute();
    
                    /* ---------------- */
                    $myDb = db::mconnect("usr_" . $uid);
    
                    $query = $myDb->prepare("DELETE FROM `pagesfollowing` WHERE `pid`='$pid'");
                    $query->execute();
    
                    $query = db::pconnect()->prepare("UPDATE `users` SET `pages_following_count`=`pages_following_count`-1 WHERE `uid`='$uid'");
                    $query->execute();
    
                    $key = array_search($pid, $pagesFollowingArr);
                    unset($pagesFollowingArr[$key]);
                    $pagesFollowingArr = array_values($pagesFollowingArr);
                    $pagesFollowingArr = json_encode($pagesFollowingArr);
                    $_SESSION['pagesfollowingarr'] = $pagesFollowingArr;
                    return 1;
                } catch (\Exception $e) {
                    return 0;
                }
            } else {
                return "You already don't follow this page.";
            }
        }

        
    }

    public function updateMyPageInfo() {
        $newName = stripslashes(strip_tags($_POST['name']));
        $newAbout = stripslashes(strip_tags($_POST['about']));
        $newPhoto = stripslashes(strip_tags($_POST['photo']));
        $newEmail = stripslashes(strip_tags($_POST['email']));
        $newSocial = stripslashes(strip_tags($_POST['social']));
        $pid = $_POST['pid'];

        $uid = $_SESSION['UID'];

        try {
            $newPhoto = explode('/', $newPhoto)[3];
            copy("../../data/temp_uploads/$newPhoto", "../../data/img_pages/$newPhoto");
        } catch (\Exception $e) {
            $newPhoto = $_POST['photo'];
        }

        $getQuery = db::pageconnect()->prepare("SELECT email FROM `info` WHERE `pid`='$pid'");
        $getQuery->execute();
        $fetch = $getQuery->fetch(PDO::FETCH_ASSOC);

        $currentEmail = $fetch['email'];

        $ret = "";
        $dbName = "usr_" . $uid;

        if ($currentEmail == $newEmail) {
            $query = db::pageconnect()->prepare("UPDATE `info` SET `page_name`=:name, `about`=:about, `pic`=:pic, `social`=:social WHERE `pid`='$pid'");
            $query->bindParam(":name", $newName);
            $query->bindParam(":about", $newAbout);
            $query->bindParam(":pic", $newPhoto);
            $query->bindParam(":social", $newSocial);
            $query->execute();

            $querym = db::mconnect($dbName)->prepare("UPDATE `mypages` SET `p_name`=:name, `p_dp`=:pic WHERE `pid`='$pid'");
            $querym->bindParam(":name", $newName);
            $querym->bindParam(":pic", $newPhoto);
            $querym->execute();

            $ret = 1;
        } else {
            if ($this->checkPageExistence($newEmail)) {
                $ret = 'Email is already registered for a page.';
            } else {
                $query = db::pageconnect()->prepare("UPDATE `info` SET `page_name`=:name, `about`=:about, `pic`=:pic, `social`=:social, `email`=:email WHERE `pid`='$pid'");
                $query->bindParam(":name", $newName);
                $query->bindParam(":about", $newAbout);
                $query->bindParam(":pic", $newPhoto);
                $query->bindParam(":social", $newSocial);
                $query->bindParam(":email", $newEmail);
                $query->execute();

                $ret = 1;
            }
        }

        return $ret;
    }   

    public function loadMyPages() {
        $dbName = "usr_" . $_SESSION['UID'];
        $query = db::mconnect($dbName)->prepare("SELECT * FROM `mypages` LIMIT 0, 7");
        $query->execute();

        if ($query->rowCount() > 0) {
            $pidArr = array();
            $retData = array();
            $html = "";

            while ($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
                $pid = $fetch['PID'];
                $pName = $fetch['p_name'];
                $pDp = $fetch['p_dp'];
                array_push($pidArr, $pid);
                $retData[$pid] = array($pDp, $pName);
            }

            for ($i = 0; $i <= count($pidArr) - 1; $i++) {
                $pidN = $pidArr[$i];
                $query = db::pageconnect()->prepare("SELECT posts_count, followers, about, social, email FROM `info` WHERE pid='$pidN'");
                $query->execute();
                $fetch = $query->fetch(PDO::FETCH_ASSOC);
                $postsCount = $fetch['posts_count'];
                $followers = $fetch['followers'];
                array_push($retData[$pidN], $postsCount);
                array_push($retData[$pidN], $followers);
                array_push($retData[$pidN], $fetch['about']);
                array_push($retData[$pidN], $fetch['social']);
                array_push($retData[$pidN], $fetch['email']);
            }

            foreach ($retData as $key => $value) {
                $dp = $value[0];
                $name = $value[1];
                $postsCount = $value[2];
                $followers = $value[3];

                $dpS = "'" . $dp . "'";
                $nameS = "'" . rawurlencode($name) . "'";
                $postsCountS = "'" . $postsCount . "'";
                $followersS = "'" . $followers . "'";
                $aboutS = "'" . $value[4] . "'";
                $socialS = "'" . rawurlencode($value[5]) . "'";
                $emailS = "'" . $value[6] . "'";

                if ($dp == '-') {
                    $dp = "../data/img_pages/yellow.jpg";
                } else {
                    $dp = "../data/img_pages/" . $dp;
                }

                $keyS = "'" . $key . "'";

                $rand = uniqid('pi');
                $randS = "'" . $rand . "'";

                $overlayPgS = "'#" . $rand . " .overlay_pg" . "'";
                $none = "'" . "none" . "'";
                $flex = "'" . "flex" . "'";

                $html .= '<div class="pageitem" id="' . $rand . '" data-attr="' . $key . '">

                    <div class="left">

                        <div class="dp"><a target="_blank" href="/page/' . $name . '"><img src="' . $dp . '" alt=""></a></div>
                        <div class="pagename"><a target="_blank" href="/page/' . $name . '"><span>' . $name . '</span></a></div>

                    </div>

                    <div class="right">

                        <div class="posts" onclick="open_uploadpost_overlay(' . $keyS . ', ' . $nameS . ', ' . $postsCountS . ', ' . $dpS . ');">

                            <ul style="list-style: none;">
                                <li><span style="font-weight: bold;font-size: 13px;color: gray;">Posts</span></li>
                                <center><li><span style="font-size: 12px;color: #333;font-weight: bold;">' . $postsCount . '</span></li></center>
                            </ul>

                        </div>

                        <div id="line" class="f"></div>

                        <div class="follow_count">

                            <ul style="list-style: none;">
                                <li><span style="font-weight: bold;font-size: 13px;color: gray;">Followers</span></li>
                                <center><li><span style="font-size: 12px;color: #333;font-weight: bold;">' . $followers . '</span></li></center>
                            </ul>

                        </div>

                        <div id="line" class="s"></div>

                        <div class="settings">

                            <i class="far fa-cog" style="cursor: pointer;" onclick="open_mypageedit(' . $keyS . ', ' . $dpS . ', ' . $nameS . ', ' . $postsCountS . ', ' . $followersS . ', ' . $aboutS . ', ' . $socialS . ', ' . $emailS . ');"></i>

                        </div>

                    </div>

                </div>';
            }

            return $html;
        } else {
            return '0';
        }
    }

    public function getPagePosts() {
		$limit = $_POST['limit'];
		$offset = $_POST['offset'];
		$total = $_POST['total'];

		$pid = $_POST['pid'];
		$pdb = "pg_".$_POST['pid'];

		if($total=='null') {
			$query = db::postsconnect()->prepare("SELECT COUNT(*) as c FROM posts.`meme` WHERE `pid`='$pid'");
			$query->execute();

			$fe_c = $query->fetch(PDO::FETCH_ASSOC);
			$total = $fe_c['c'];

		}

		$query = db::postsconnect()->prepare("SELECT date, image_link, like_count, caption FROM posts.`meme` WHERE `pid`='$pid' LIMIT $offset, $limit");
		$query->execute();		

		if($query->rowCount()>0) {
			
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				
				$date = $row['date'];
				$image_link = $row['image_link'];
				$like_count = $row['like_count'];
				$caption = $row['caption'];
				$rand = uniqid('psts_');

				?>
	
				<div class="psts <?php echo $rand; ?>">
					
					<span class="time"><?php echo $date; ?></span>
					
					<?php if(!is_null($caption) AND $caption!='') { ?>
					<br>
					<span class="caption" style="font-size: 12px;"><?php echo $caption; ?></span>
					
					<?php } ?>

					<br>

					<img src="../data/post_img/<?php echo $image_link; ?>" alt="">	
					<br>
					<br>

					<span class="pos_reacts"><b style="color: green;"><?php echo $like_count; ?></b> <font style="font-size: 13px;">Positive reacts</font></span>
						
				</div>
		
				<br>
				<br>

				<?php
			
			}

			if($total-$limit>0) {
				?>
				
				<center>
					<span style="color: blue;padding-top:5px;padding-bottom: 5px;text-decoration: underline;cursor: pointer;font-size: 12px;" onclick="loadposts('<?php echo $offset+12; ?>', '<?php echo $limit+12; ?>', '<?php echo $total; ?>', this)">Load More</span>
				</center>

				<?php
			}

		}

		else {
			?>
			
			<center>
				<span style="color: gray;font-size: 12px;letter-spacing: 0.1px;">This page has'nt uploaded any memes yet.</span>
			</center>

			<?php
		}


	}

}

$obj = new pageOperations;

if(isset($_GET['action']) && !empty($_GET['action'])) {
    
    $act = $_GET['action'];
    if($act=='create-page') {
        echo $obj->createPage(); 
    } 
    else if($act=='update-mypage-info') {
        echo $obj->updateMyPageInfo(); 
    }
    else if($act=='load-mypages') {
        echo $obj->loadMyPages(); 
    }
    else if($act=='get-page-posts') {
        echo $obj->getPagePosts(); 
    }
    else if($act=='follow-state-change') {
        if($_POST['statechangetype']=='follow') {
            echo $obj->followStateChange('follow'); 
        }
        else {
            echo $obj->followStateChange('unfollow'); 
        }
    }
    else {
        header('Location: ../../notfound.html');
    }

} else {
    header('Location: ../../notfound.html');
}