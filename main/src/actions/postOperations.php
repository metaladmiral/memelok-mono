<?php 

session_start();
include 'dbh.php';

class postOperations extends db {

    public function uploadMeme() {
		
        $caption = (isset($_POST['caption'])) ? stripslashes(strip_tags($_POST['caption'])) : $caption = null;

		$tags = json_decode($_POST['tags'], true);

        $tags = (sizeof($tags)) ? json_encode($tags) : "random";

		$pid = $_POST['which'];
		$img = explode('/', $_POST['img'])[1];

		$img_big = "big_".$img;
		$img_small = "small_".$img;

		$pagename = $_POST['pagename'];
		$pagedp = $_POST['pagedp'];
		
		/* mid */

		$pidsplit = str_split($pid);
		$imgsplit = str_split($img);

		$prefix = $pidsplit[0].$pidsplit[1].$pidsplit[2].$pidsplit[3].$imgsplit[0].$imgsplit[1].$imgsplit[2].rand(0, 1000);
		$mid = uniqid($prefix, true);

		/* */ 
		
		$date = date("Y-m-d H:i:s", strtotime(date('h:i:sa')));;
		$like_count = 0;
		$likes = json_encode(array());
		$comments = json_encode(array());
		$dccount = 0;

		/* queries */
		$pgtable = "pg_".$pid;

		try {

			copy("../../data/temp_uploads/".$img, "../../data/post_img/".$img);	

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, "http://localhost:5000/optimizememe?imlink=$img&imbig=$img_big&imsmall=$img_small");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$output = curl_exec($ch);
			curl_close($ch);


			$query = db::mconnect($pgtable)->prepare("INSERT INTO `posts`(mid) VALUES(:mid)");
			$query->bindParam(':mid', $mid);
			$query->execute();

			$query = db::mconnect("posts")->prepare("INSERT INTO `meme`(`mid`, `date`, `page_name`, `pid`, `tags`, `image_link`, `like_count`, `dislike_count`, `caption`, `pagedp`) VALUES(:mid, :daten, :page_name, :pid, :tags, :image, :like_count, :dccount, :caption, :pagedp)");

			$query->bindParam(':mid', $mid);
			$query->bindParam(':daten', $date);
			$query->bindParam(':page_name', $pagename);
			$query->bindParam(':pid', $pid);
			$query->bindParam(':tags', $tags);
			$query->bindParam(':image', $img);
			$query->bindParam(':dccount', $dccount);
			$query->bindParam(':like_count', $like_count);
			$query->bindParam(':caption', $caption);
			$query->bindParam(':pagedp', $pagedp);

			$query->execute();

			$npost_count = $_POST['pc']+1;

			$query = db::pageconnect()->prepare("UPDATE `info` SET `posts_count`='".$npost_count."' WHERE `pid`='".$pid."'");
			$query->execute();

			return 1;

		}
		catch(\Exception $e) {
			return $e->getMessage();
		}

	}

    public function reactLike() {
		try {
			
			$mid = $_POST['mid'];
			$db = "usr_".$_SESSION['UID'];
			$query = db::mconnect($db)->prepare("INSERT INTO `likes`(mid) VALUES('$mid')");
			$query->execute();

			$query = db::postsconnect()->prepare("SELECT like_count as lc FROM `meme` WHERE `mid`='$mid'");
			$query->execute();
			$lc = (int)$query->fetch(PDO::FETCH_ASSOC)['lc']+1;

			$query = db::postsconnect()->prepare("UPDATE `meme` SET like_count='$lc' WHERE `mid`='$mid'");
			$query->execute();

			return 1;

		}catch(\Exception $e) {
			return $e->getMessage();
		}

	}

	public function reactDislike() {
		try {
			$mid = $_POST['mid'];
			$db = "usr_".$_SESSION['UID'];
			$query = db::mconnect($db)->prepare("INSERT INTO `likes`(mid) VALUES('$mid')");
			$query->execute();

			$query = db::postsconnect()->prepare("SELECT dislike_count as lc FROM `meme` WHERE `mid`='$mid'");
			$query->execute();
			$lc = (int)$query->fetch(PDO::FETCH_ASSOC)['lc']+1;

			$query = db::postsconnect()->prepare("UPDATE `meme` SET dislike_count='$lc' WHERE `mid`='$mid'");
			$query->execute();
			
			return 1;

		}
		catch(\Exception $e) {
			return $e->getMessage();
		}
	}

}

$obj = new postOperations;

if(isset($_GET['action']) && !empty($_GET['action'])) {
    
    $act = $_GET['action'];
    if($act=='react-to-post') {
        if($_POST['reacttype']=='positive') {

            echo $obj->reactLike(); 
        }
        else {
            echo $obj->reactDislike(); 
        }
    } 
    else if($act=='upload-post') {
        echo $obj->uploadMeme(); 
    }
    else {
        header('Location: ../../notfound.html');
    }

} else {
    header('Location: ../../notfound.html');
}