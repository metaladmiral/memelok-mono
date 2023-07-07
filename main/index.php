<?php

session_start();
ob_start();

include './dbh.php';

$server = explode('.', $_SERVER['SERVER_NAME']);
$domain = count($server)-1;
$host = count($server)-2;
$server = $server[$host].".".$server[$domain];

if(isset($_COOKIE['LID'])) {
	$lid = $_COOKIE['LID'];
	if(empty($lid)) {
		header('Location: ./login');
	}
	else {
		$uid = $_SESSION['UID'];
		if(empty($uid)) {
			header('Location: ./logout');
		}
	}
}
else {
	header('Location: ./login');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Home - Memelok | Memes | Best Indian memes | Best Memes Collection</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./static-assets/fontawesome/css/all.min.css">
	<script src="static-assets/scripts/jquery.js"></script>
	<meta name="description" content="Log in or Create an account on Memelok. Get the best Indian memes and funny memes from best memers around India, chat with your friends">
	<meta name="keywords" content="home, memelok home, home page, memelok, memes, meme, best indian memes, best memes collection, funny memes, best memes, adult memes">
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">

</head>
<body>

	<!-- nav dropdowns !-->
	
		<a class="downloadmeme"></a>

		<div class="overlay_responsive">
			
		</div>

		<audio id="message_noti">
		  <source src="./static-assets/sounds/insight.ogg" type="audio/ogg">
		</audio>

		<div class="search_resp_dropdown nav_dropdown" style="display: none;">
			<i class="far fa-angle-up"></i>
			<div class="mcont">
				<input type="search" class="resp_search_input" id='search' onfocus="focussearchbar()" onfocusout="focussoutsearchbar();" placeholder="Search for people, pages.." spellcheck="false" onkeyup="entercapture(event, this, this.value);">
				<div class="highlgtr"><span class="far fa-search" style="background: transparent;font-size:17.5px;color: white;"></span></div>
			</div>
		</div>

		<div class="nav_dropdown freq_dropdown" style="display: none;">
			<i class="far fa-angle-up"></i>
			<div class="mcont">
				
				<div class="top">
					<span id="heading">Friend Requests</span>
				</div>

				<div class="bottom">
					
					<div class="spinner loader"></div>

					<div class="reqs">

					</div>

				</div>

			</div>
		</div>

		<div class="nav_dropdown noti_dropdown" style="display: none;">
			<i class="far fa-angle-up"></i>
			<div class="mcont">
				
				<div class="top">
					<span id='heading'>Notifications</span>
					<div class="more"><a href="" onclick="markallnotiread();return false;">Mark all as Read</a></div>
				</div>

				<div class="bottom">
					
					<div class="loader spinner"></div>

					<div class="noti_main">

						
					</div>

				</div>

			</div>
		</div>
		<div class="nav_dropdown usrstngs_dropdown" style="display: none;">
			<i class="far fa-angle-up"></i>
			<div class="mcont">
				
				<ul>
					<li onclick="dropdownaction('settings');">Settings</li>
					<li onclick="dropdownaction('createpage');">Create a Page</li>
					<li onclick="dropdownaction('mypages');">My Pages</li>
					<li onclick="dropdownaction('logout');">Log Out</li>
				</ul>

			</div>
		</div>

		<!-- ---------------- !-->

		<div class="alert_main">
			<div class="icon">

				<i class="far fa-info-circle"></i>

			</div>

			<div class="info_content">
				<span>Server Error. Please Try Again Later.</span>
			</div>
		</div>

	<div class="left_divider">	
		
		<div class="top_heading" state="enabled">
			<h2>CHATBOX</h2>
		</div>

		<div class="more_">
			
			<div class="left_more_" onclick="disablechat()" cdata='1'>
				<i style="cursor: pointer;" class="far fa-power-off"></i>
			</div>

			<div class='center_more_' style="color: #00b300;">&bull;</div>

			<div class="right_more_" onclick="chatanimation();"><i class="far fa-exchange-alt" style="cursor: pointer;"></i></div>

		</div>

		<div class="onlinefrnds">
			<div id="line" data-value="Online Friends (0)" f_count="" data-change='1'></div>
		</div>

		<div class="onlinefrndsmain">

			<div class='loader' id='offonchatspin'></div>

			<div class="chathistory">
			
				
			</div>

			<div class="onnfrnds">
				
			</div>

			<div class="chatwindow" data-username="" data-fullname="" data-uid="" data-pic="" data-cid="" data-which="">
				
				<div class="top">

					<i class="fas fa-arrow-left" onclick="removechatwindow(document.querySelector('.chatwindow').getAttribute('data-which'));"></i>
					
					<div class="dp"><img src="" alt="pop"></div>
					&nbsp;&nbsp;
					<span style="font-family: ;font-size: 13px;" id='chat_username'>Username</span>
					&nbsp;&nbsp;
					<span style="color: #00b300;font-size: 20px;" class="onlinestatus" style="display: none;">&bull;</span>

				</div>

				<div class="mainchat">
					
					<div class="loader spinner"></div>

					<div class="maindata">
						<ul>
							
						</ul>
						
					</div>

				</div>				

				<div class="bottom_chatm">
						
					<input type="text" placeholder="Enter a Message" id='chat_mess_input' onkeyup="messevent(event);">

					<script>
						function messevent(e) {
							if(e.code=='Enter') {
								sendmess();
								document.querySelector('#chat_mess_input').value = "";
							}
						}

					</script>

					<i class="fas fa-paper-plane" style="color: white;position: absolute;right: 10px;font-size: 22px;cursor: pointer;" onclick="sendmess();"></i>

				</div>

			</div>

			<script>
				loadchatinterval = setInterval(function(){
					loadlazychat();
				}, 2500);
			</script>			

		</div>
		
	</div>

	<div class='right_divider' id='autofocus'>

		<div class="nav_main">

			<div class="logo">
				<img src="./static-assets/img/logo_dev1.png" alt="">
			</div>

			<div class="main_spinner">
				<div class="loader spinner"></div>
			</div>

			<div class="search">
				
				<div class="search_bar" style="">
					<input type="search" id='search' onfocus="focussearchbar()" onfocusout="focussoutsearchbar();" placeholder="Search for people, pages.." spellcheck="false" onkeyup="entercapture(event, this, this.value);">
					<i class="far fa-times" style="" onclick="document.querySelector('.ico_search').style.display='block';document.querySelector('.search_bar').style.display='none';"></i>
					<div class="highlgtr"><i class="far fa-search"></i></div>
				</div>

				<div class="ico_search" style="" onclick="searchbar_toggle('open');"><i class="far fa-search nav_icon"></i><div class="hghlgtr"></div></div>
				

			</div>

			<div class="right">
				<!--
				<div class="ico"><i class="far fa-users nav_icon_hover nav_icon" id='nav_friendreq' aria-hidden='true'></i></div>

				<div class="ico"><i class="far fa-bells nav_icon" id='nav_noti'></i></div>

				<div class="ico"><i class="far fa-users-cog nav_icon" id='nav_usersettings'></i></div>
				----------------------------
				<i class="far fa-users nav_icon_hover nav_icon" id='nav_friendreq' onclick="open_nav_dropdown(this)" aria-hidden='true'></i>
				
				<i class="far fa-bells nav_icon" id='nav_noti'></i>
				
				<i class="far fa-users-cog nav_icon" id='nav_usersettings'></i>
				--------------------------
				
				<div class="ico" id='ico1'><i onmouseover="document.querySelector('#ico1').style.border = '2px solid #ffc61a';" class="far fa-users nav_icon_hover nav_icon" id='nav_friendreq' onclick="open_nav_dropdown(this)" onmouseout="document.querySelector('#ico1').style.border = '2px solid gray';" aria-hidden='true'></i></div>

				<div class="ico" id='ico2'><i class="far fa-bells nav_icon" id='nav_noti' onmouseover="document.querySelector('#ico2').style.border = '2px solid #ffc61a';" onmouseout="document.querySelector('#ico2').style.border = '2px solid gray';"></i></div>

				<div class="ico" id='ico3'><i class="far fa-users-cog nav_icon" id='nav_usersettings' onmouseover="document.querySelector('#ico3').style.border = '2px solid #ffc61a';" onmouseout="document.querySelector('#ico3').style.border = '2px solid gray';"></i></div>

				!-->

				<div class="ico" id='ico1' cdata='1' onclick="open_nav_dropdown('freq');" onmouseover="hover_ico('ico1');" onmouseout="remove_hover_ico('ico1');"><i class="far fa-users nav_icon_hover nav_icon" id='nav_friendreq' aria-hidden='true'></i><div class="hghlgtr"></div></div>
				
				<div class="ico" id='ico2' cdata='1' onclick="open_nav_dropdown('noti');" onmouseover="hover_ico('ico2');" onmouseout="remove_hover_ico('ico2');"><i class="far fa-bells nav_icon" id='nav_noti'></i><div class="hghlgtr"></div></div>
				
				<div class="ico" id='ico3' cdata='1' onclick="open_nav_dropdown('usrsttngs');" onmouseover="hover_ico('ico3');" onmouseout="remove_hover_ico('ico3');"><i class="far fa-users-cog nav_icon" id='nav_usersettings'></i><div class="hghlgtr"></div></div>

			</div>

		</div>

		<div class="right_main">

			<div id="feed">

				<div class="loader postloader"></div>	

			</div>

			<div class="extras">
				
				<div class="pgsugg">
					
					<h1>Page Suggestions</h1>
					
					<hr style="visibility: hidden;">
					<hr style="visibility: hidden;">
					<hr style="visibility: hidden;">	

					<div class="main_bottom">
					
						<div class="loader spinner" style="display: block;width: 12px;height: 12px;margin-left: 5px;"></div>

						<ul style="list-style: none;">
							
						</ul>

					</div>

				</div>
				
				<br>

				<div class="ad">
					
					<div id='morelinks'><a href="/about-us" target="_blank" style="text-decoration: none;"><span>About</span></a> &bull; <a href="/terms" target="_blank" style="text-decoration: none;"><span>Terms</span></a> &bull; <a href="/terms" target="_blank" style="text-decoration: none;"><span style="">Give us a Feedback</span></a></div>
					<span style="font-size: 12px;color: gray;">A PS Production &copy; <?php echo date('Y'); ?>. </span>	
					<br>
					<span style="font-size: 12px;color: #b3b3b3;">All rights reserved.</span>

					<br>
					<hr style="visibility: hidden;">
					<br>
					<b style="letter-spacing: 0.1px;color: #222;font-size: 12.8px;">Common queries - </b>
					<br>
					<hr style="visibility: hidden;">
					<hr style="visibility: hidden;">

					<a href="/how-to-upload-a-meme" target="_blank" style="color: #222;font-size: 12px;">How to upload a meme?</a>
					<br>
					<a href="/how-to-create-a-page" target="_blank" style="color: #222;font-size: 12px;">How to create a page?</a>

				</div>

			</div>

		</div>

		<div class="overlay">
			
		</div>


		<div class="overlay search_overlay">

			<div class="back_arrow">

				<i class="fas fa-arrow-left" style="" onclick='document.querySelector(".search_overlay").style.display="none";'></i>

			</div>

			<div class="main_search">

				<div class="top_togglebtw">
					
					<h1 style="font-size: 20px;font-family: 'Poppins', sans-serif;position: relative;left: 25px;">Search</h1>

					<div class="typetoggle">
						<label style="font-size: 13px;color:gray;" for="toggle">Type: </label>
						<select id="toggle" onchange="search(document.querySelector('#search').value, this.value);">
							<option value="people">People</option>
							<option value="pages">Pages</option>
						</select>
					</div>

				</div>

				<div class="bottom">
					
					<div class="spinner loader"></div>

					<div class="content"></div>

				</div>
				
			</div>

		</div>

	</div>

	<script>

		function dropdownaction(e) {
			var link = "";
			var spinner =  document.querySelector('.main_spinner');

			var f = e;

			spinner.style.display = "flex";

			try {
				document.querySelector('.search_overlay').style.display = "none";
			}
			catch(err) {
				
			}

			if(e=='logout') {
				link = 'logout';

				clearInterval(updateconteinterval);

				localStorage.clear();

				setTimeout(function(){
					spinner.style.display = "none";
					window.location = "http://<?php echo $server; ?>/logout";
				}, 900);
			}
			else {
				link = './src/'+e+'';
				if(e=='profile') {
					link = './src/'+e+'?id=<?php echo $_SESSION['UID']; ?>';
				}
				var xml = new XMLHttpRequest();
				xml.onreadystatechange = function() {
					if(this.readyState==4 && this.status==200) {
						var resp = this.responseText;
						setTimeout(function() {
							
							if(e=='settings' && window.innerWidth<950 && window.innerWidth>650) {
								document.querySelector('.overlay_responsive').innerHTML = "";	
								document.querySelector('.overlay_responsive').style.display = "flex";
								spinner.style.display = "none";
								document.querySelector('.overlay_responsive').innerHTML = resp;
							}	
							else {
								document.querySelector('.overlay').innerHTML = "";	
								document.querySelector('.overlay').style.display = "block";
								spinner.style.display = "none";
								document.querySelector('.overlay').innerHTML = resp;
				
								if(f=='mypages') {
									load_mypages();
								}
								setTimeout(function() {
									document.querySelector('#ico3 i').style.color = "rgba(0, 0, 0, 0.5)";
									document.querySelector('#ico3 .hghlgtr').style.background = "gray";
									document.querySelector(".usrstngs_dropdown").style.display = "none";
									document.querySelector('.nav_main').style.borderBottom = "1px solid rgba(0, 0, 0, 0.20)";
									document.querySelector('#ico3').setAttribute('cdata', "1");
									document.querySelector('#ico3').setAttribute('onmouseout', "remove_hover_ico('ico3')");
								}, 4500);
							}

						}, 1225);
					}
				}
				xml.open("POST", link);
				xml.withCredentials = true;
				xml.send();
			}

		}

		function usrncheck() {

			document.querySelector('.right_1 .spinner').style.display = "none";
			document.querySelector('.right_1 #usrnavl').style.display = "none";
			document.querySelector('.right_1 #usrnnavl').style.display = "none";
			var val = document.querySelector('.right_1 .username input').value;
			if(val=='<?php echo $_SESSION['username']; ?>') {
				document.querySelector('.right_1 .username input').setAttribute('toupdate', '0');
			}
			else {

				document.querySelector('.right_1 #usrnavl').style.display = "none";
				document.querySelector('.right_1 .spinner').style.display = "none";
				document.querySelector('.right_1 .username input').setAttribute('toupdate', '0');
				document.querySelector('.right_1 #usrnnavl').style.display = "none";

				if(val.length>=7 && val.length<=18) {
					
					document.querySelector('.right_1 .spinner').style.display = "block";
					var xml = new XMLHttpRequest();
					xml.onreadystatechange = function() {
						if(this.readyState==4 && this.status==200) {
							var resp = this.responseText;
							if(resp=='1') {
								document.querySelector('.right_1 .spinner').style.display = "none";
								document.querySelector('.right_1 #usrnnavl').style.display = "none";
								document.querySelector('.right_1 .username input').setAttribute('toupdate', '1');
								document.querySelector('.right_1 #usrnavl').style.display = "block";
							}
							else if(resp=='0') {
								document.querySelector('.right_1 #usrnavl').style.display = "none";
								document.querySelector('.right_1 .spinner').style.display = "none";
								document.querySelector('.right_1 .username input').setAttribute('toupdate', '0');
								document.querySelector('.right_1 #usrnnavl').style.display = "block";
							}
							else {
								document.querySelector('.right_1 #usrnavl').style.display = "none";
								document.querySelector('.right_1 .spinner').style.display = "none";
								document.querySelector('.right_1 #usrnnavl').style.display = "block";
								document.querySelector('.right_1 .username input').setAttribute('toupdate', '0');
								alertmain(resp);
								
							}
						}
					}
					xml.open("POST", "/api/userAuth/check-username");
					xml.withCredentials = true;
					var formdata = new FormData();
					formdata.append("value", val);
					xml.send(formdata);
				}
				else {
					document.querySelector('.right_1 .username input').setAttribute('toupdate', '0');
				}

			}


			}

			function openchat(username, uid, pic, fullname, id) {

		var cid = document.querySelector('#'+id).getAttribute('data_cid');
		document.querySelector('.chatwindow .top .dp img').setAttribute('src', './data/img_users/'+pic);
			document.querySelector('.chatwindow .top #chat_username').innerHTML = username;
			document.querySelector('.chatwindow').setAttribute('data-username', username);
			document.querySelector('.chatwindow').setAttribute('data-uid', uid);
			document.querySelector('.chatwindow').setAttribute('data-fullname', fullname);
			document.querySelector('.chatwindow').setAttribute('data-cid', cid);
			document.querySelector('.chatwindow').style.display = "block";

			document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Chat window');

			document.querySelector('.chatwindow .mainchat .maindata ul').innerHTML = "";

			loadchat(uid, '<?php echo $_SESSION['UID']; ?>', username);

			var xml = new XMLHttpRequest();
			xml.onreadystatechange = function() {
				if(this.status==200 && this.readyState==4) {
					
				}
			}
			var formdata = new FormData();
			formdata.append('uidf', uid);
			formdata.append('uidm', '<?php echo $_SESSION['UID']; ?>');
			formdata.append('updatelmess', '1');
			xml.open("POST", "./src/chat/change_last_message");
			xml.withCredentials = true;
			xml.send(formdata);

			/* get cid + online */
			getcidinterval = setInterval(function(){
				var xml = new XMLHttpRequest();
				var uid = document.querySelector('.chatwindow').getAttribute('data-uid');
				xml.onreadystatechange = function() {
					if(this.status==200 && this.readyState==4) {
						var resp = JSON.parse(this.responseText);

						var cid = resp['cid'];
						var online = resp['online'];

						document.querySelector('.chatwindow').setAttribute('data-cid', cid);

						if(online==1) {
							document.querySelector('.chatwindow .top .onlinestatus').style.display = "block";
						}
						else {
							document.querySelector('.chatwindow .top .onlinestatus').style.display = "none";
						}

					}
				}
				var formdata = new FormData();
				formdata.append('uid', uid);
				xml.open("POST", "./src/chat/getcid");
				xml.withCredentials = true;
				xml.send(formdata);
			}, 800);

			updatelmesinterval = setInterval(function(){
				var xml = new XMLHttpRequest();
				xml.onreadystatechange = function() {
					if(this.status==200 && this.readyState==4) {
					
					}
				}
				var formdata = new FormData();
				formdata.append('uidf', uid);
				formdata.append('uidm', '<?php echo $_SESSION['UID']; ?>');
				formdata.append('updatelmess', '1');
				xml.open("POST", "./src/chat/change_last_message");
				xml.withCredentials = true;
				xml.send(formdata);
			}, 3500);

		}	

		document.addEventListener('readystatechange', event => {

			if (event.target.readyState === "complete") {
				document.querySelector('#offonchatspin').style.display = "block";
				document.querySelector('.postloader').style.display = "block";
				localStorage.setItem('uid', '<?php echo $_SESSION['UID']; ?>');			    	
				setTimeout(function() {
					loadlazyposts();
				}, 800);

				setTimeout(function() {
					loadlazychat();
				}, 900);

				setTimeout(function(){
					loadlazypgsugg();
				}, 900);

				setInterval(function(){
					var xml = new XMLHttpRequest();
					xml.onreadystatechange = function() {
						if(this.readyState==4 && this.status==200) {
							if(this.responseText!='<?php echo $_COOKIE['PSID']; ?>') {
								var r = confirm("A computer has loggedin from your account. You are being logged out.");
								if(r==true) {
									window.location = "http://<?php echo $server; ?>/logout";
								}
								else {
									window.location = "http://<?php echo $server; ?>/logout";	
								}
								
							}
						}
					}
					xml.open("GET", "./src/actions/chksessid");
					xml.withCredentials = true;
					xml.send();
				}, 10000);

				getFriendRequestsCount();
				
			}

			});

			// Friend Requests //
			function accept_request(friendUid, domid) {
				document.querySelector('#overlay_'+domid).style.display = "flex";
				var xml = new XMLHttpRequest();
				xml.onreadystatechange= function() {
					if(this.readyState==4 && this.status==200) {
						var resp = this.responseText;
						if(resp==1) {
						setTimeout(function(){
							document.querySelector("#freq-items_"+domid+" #accept_request").innerHTML = 'Accepted &#10004;';
							document.querySelector("#freq-items_"+domid+" #accept_request").style.width = "70px";
							document.querySelector("#freq-items_"+domid+" #accept_request").setAttribute("disabled", "true");
							document.querySelector("#freq-items_"+domid+" #accept_request").style.cursor = "auto";
							document.querySelector("#freq-items_"+domid+" #decline_request").setAttribute("disabled", "true");
							document.querySelector("#freq-items_"+domid+" #decline_request").style.cursor = "auto";
							document.querySelector("#freq-items_"+domid+" #accept_request").removeAttribute('onclick');
							document.querySelector("#freq-items_"+domid+" #decline_request").removeAttribute('onclick');
							document.querySelector('#overlay_'+domid).style.display = "none";
						}, 650);

						var xml_req = new XMLHttpRequest();
						xml_req.onreadystatechange = function() {
							if(this.readyState==4 && this.status==200) {
							}
						}
						var formdata = new FormData();
						var content = "<?php echo $_SESSION['username']; ?>"+" accepted your friend request.";
						formdata.append("key", friendUid);
						formdata.append("content", content);
						xml_req.open("POST", "/api/notifications/send-notifications");
						xml_req.withCredentials = true;
						xml_req.send(formdata);
						
					}
					else {
						alertmain('An error Occured!');
						
					}

					}

				}
				xml.open("POST", "./api/friendRequests/accept");
				xml.withCredentials = true;
				var formdata = new FormData();
				formdata.append("friendUid", friendUid);
				xml.send(formdata);
			}

			function decline_request(friendUid, id) {
				document.querySelector('#overlay_'+id).style.display = "flex";
				var xml = new XMLHttpRequest();
				xml.onreadystatechange= function() {
					if(this.readyState==4 && this.status==200) {
						var resp = this.responseText;

						if(resp==1) {
							setTimeout(function(){
								document.querySelector("#freq-items_"+id+" #decline_request").innerHTML = 'Declined &#10004;';
								document.querySelector("#freq-items_"+id+" #decline_request").style.width = "70px";
								document.querySelector("#freq-items_"+id+" #decline_request").setAttribute("disabled", "true");
								document.querySelector("#freq-items_"+id+" #decline_request").style.cursor = "auto";
								document.querySelector("#freq-items_"+id+" #accept_request").setAttribute("disabled", "true");
								document.querySelector("#freq-items_"+id+" #accept_request").style.cursor = "auto";
								document.querySelector("#freq-items_"+id+" #accept_request").removeAttribute('onclick');
								document.querySelector("#freq-items_"+id+" #decline_request").removeAttribute('onclick');
								document.querySelector('#overlay_'+id).style.display = "none";
							}, 650);
						}
						else {
							alertmain('An Error Occured!');
							
						}

					}
				}
				xml.open("POST", "./api/friendRequests/decline");
				xml.withCredentials = true;
				var formdata = new FormData();
				formdata.append("friendUid", friendUid);
				formdata.append("id", id);
				xml.send(formdata);
			}

		// Friend Requests ends //

	</script>

	<!-- <script defer src="/socket.io/socket.io.js"></script> -->
	<script src="https://cdn.socket.io/4.7.0/socket.io.min.js" crossorigin="anonymous"></script>
	<script defer src="./src/chat/client.js"></script>
	<script src="./static-assets/scripts/index.js"></script>


</body>
</html>