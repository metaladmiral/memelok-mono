<?php

include './dbh.php';

session_start();
ob_start();


if($_SERVER['SERVER_NAME']=='::1') {
	$server = "localhost";
}
else {
	$server = $_SERVER['SERVER_NAME'];
}

if(isset($_COOKIE['LID'])) {
	if(empty($_COOKIE['LID'])) {
		setcookie('LID', "",  time()-3600);
	}
	else {
		header('Location: http://'.$server.'/');
	}
}
else {
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login | Memelok | Memes | Best Indian memes | Best Memes Collection</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./static-assets/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="css/getin.css">
	<meta name="description" content="Log in or Create an account on Memelok. Get the best Indian memes and funny memes from best memers around India, chat with your friends">
	<meta name="keywords" content="login, memelok login, login page, sign in, sign up, create an account, memelok, memes, meme, best indian memes, best memes collection, funny memes">
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">

	<script src="static-assets/scripts/jquery.js"></script>
	<script>
		localStorage.clear();
	</script>
</head>
<body>

	<img src="static-assets/img/background.jpg" class="mainimg" alt="">
	<div class="bgimgoverlay"></div>

	<div class="overlayChkEmail">
	
		<div class="enterotp">
			
			<span style="font-size: 13.20px;color: gray;">You will recieve an OTP from memelok to your given email. Please provide it below to continue.</span>
			
			<br>
			<br>

			<input type="number" id='otpinput' class="" max="4" placeholder="Enter the OTP recieved"> &nbsp; <button onclick="validateOtp();">Continue</button>
			
			<br>
			<br>
			
			<a style="color: blue;font-size: 12px;cursor: pointer;"><i class="fal fa-sync"></i> Resend OTP</a>

		</div>

	</div>

	<div class="alert_main">
		<div class="icon">

			<i class="far fa-info-circle"></i>

		</div>

		<div class="info_content">
			<span>Server Error. Please Try Again Later.</span>
		</div>

	</div>
	
	<div class="nav_main">
		
		<div class="logo">
			<img src="././static-assets/img/icon-main.png">
		</div>

	</div>

	<div class="main">

	<div class="flex_wrapper">

		<div class="right">
			
			<div class='top'>
				
				<h1>SIGN IN</h1>

				<div class="loader spinner"></div>

				<span onclick="openSignup()" style='color: var(--hover-color);'><font>Signup</font> <i style="font-size: 12px;" class="far fa-arrow-circle-right"></i></span>

			</div>

			<div class="center login">
				
				<form action="" method="POST" onsubmit="return signinFormSubmit();">
					
					<div class="usrdiv">
					
						<input type="email" placeholder="Email" class="input iusr" id='login_cred' onfocus="focusInput('usr');" onfocusout="removeFocusInput('usr');" autocomplete="off" spellcheck="false" required>

						<div class="highlighter"><i style="color: white;" class="far fa-user"></i></div>
					
					</div>

					<div class="passdiv">
						
						<input type="password" placeholder="Password" class="input ipass" autocomplete="false" id='login_pass' onfocus="focusInput('pass');" onfocusout="removeFocusInput('pass');" spellcheck="false" required>

						<div class="highlighter"><i style="color: white;" class="far fa-lock"></i></div>

					</div>


					<span style="" id="forgot_pass_span">Forgot Password?</span>

					<br>
					<br>
					
					<div class="subaspan">
						<input type="submit" name="sbm_login" value="Sign In">
					</div>

				</form>

				<br>

				<h4 style="position: relative;left: 5px;top: 0px;">OR</h4>

				<br>

				<div style="position: relative;left: 5px;"><span style="font-size: 13.75px;">Not a Member Yet?</span> <br> <a href="#" style="font-size: 13px;color: var(--hover-color);" onclick="opensignup();return false;">Sign Up</a></div>

			</div>


			<div class="center signup" style="">
				<!-- pic, fullname, username, email, social media, password, bio, Topics Interesed ,gender, birthday !-->

				<form action="" enctype="multipart/form-data" method="POST" onsubmit="sendOtp();return false;" autocomplete="off">

					<div class="pic">
						
						<input type="file" accept="image/png, image/jpg, image/jpeg" id="photo" onchange="picShow()" style="display: none;">
					
						<label for="photo">
							
							<div class="upload pseudo" data="0">
							</div>

						</label>

						<div class="loader spinner"></div>

					</div>

					<br>

					<div class="fullname">
						
						<input type="text" placeholder="Type your Fullname" class="input" autocomplete="off" spellcheck="false" onfocus="signupInputFocus('fullname')" onfocusout="removeSignupInputFocus('fullname')" required>
						
						<div class="highlighter"><i style="color: white;" class="far fa-address-book"></i></div>

					</div>

					<br>

					<div class="username">

						<input type="text" placeholder="Type in a Username" class="input" autocomplete="false" spellcheck="false" onfocus="signupInputFocus('username')" onfocusout="removeSignupInputFocus('username')" onkeyup="usrncheck()" minlength="5" required>
						
						<div class="highlighter"><i style="color: white;" class="far fa-user"></i></div>

						<div class="loader" id="usrncheck"></div>

						<i class="far fa-check" id='usrnavl'></i>

						<i class="far fa-times" id='usrnnavl'></i>

						

					</div>

					<br>

					<div class="email">

						<input type="email" placeholder="Type in Your Email" class="input" autocomplete="false" spellcheck="false" onfocus="signupInputFocus('email')" onfocusout="removeSignupInputFocus('email')" required>
						
						<div class="highlighter"><i style="color: white;" class="far fa-envelope"></i></div>						

					</div>

					<br>

					<div class="gender">
						
						<input type="hidden" id='genderval' value="0">

						<div style="margin-left: 5px;">
							<label for="gender" style="font-size: 14px;color: white;">Gender: </label>
							<input type="radio" value="male" name="gender" id='gender_male' style="position: relative;top:1.5px;" onchange="document.querySelector('#genderval').setAttribute('value', 'male');"><font style="font-size: 13px;margin-left: 1.5px;">Male</font>
							<input type="radio" value="female" name="gender" id='gender_female' style="position: relative;top:1.5px;" onchange="document.querySelector('#genderval').setAttribute('value', 'female');"><font style="font-size: 13px;margin-left: 1.5px;">Female</font>
							<input type="radio" value="other" name="gender" id='gender_other' style="position: relative;top:1.5px;" onchange="document.querySelector('#genderval').setAttribute('value', 'other');"><font style="font-size: 13px;margin-left: 1.5px;">Other</font>
						</div>

					</div>

					<br>

					<div class="bio">
						<label style="font-size: 14px;color: gray;position: relative;left: 5px;color:white;">Bio: </label>
						<br>
						<p><textarea name="" id="" maxlength="100" placeholder="Type your Bio.." spellcheck="false" autocomplete="false" onfocus="document.querySelector('.right .top').style.borderBottom = '2px solid var(--hover-color)';document.querySelector('.bio label').style.color = 'var(--hover-color)';document.querySelector('.bio label').style.fontWeight = '600';scrollfbio();" onfocusout="document.querySelector('.right .top').style.borderBottom = '1px solid var(--main-border)';document.querySelector('.bio label').style.color = 'gray';document.querySelector('.bio label').style.fontWeight = '400';"></textarea></p>
					</div>

					<script>
						
					</script>

					<br>

					<div class="topics">
						
						<span class="topspan" style="font-size: 12px;color: white;"><i class="fas fa-info-circle" style="position: relative;top:0px;color:white;"></i> Select your interests.</span>
					

					<div class="bottom">
						
						<?php

							$tags = array("School Life", "College Life", "Indian Parents", "Technology", "Sports", "Childhood", "Dailylife", "Bollywood", "Indian Politics", "Animals", "Engineers", "Doctors", "Indian Weddings", "10 Year Challenge", "Adult", "Cartoons", "Indian Babas", "Sarcastic", "Indian TV Ads", "Tik Tok", "Reactions", "Relationship", "Teenage Life", "Humourous", "Indian History", "Nature");

							$selectS = "'"."select"."'";

							for($i=0;$i<=sizeof($tags)-1;$i++) {
								
								echo '<label>
						
							<div id="tagcheckbox">
							
								<div class="checkbox_cont">
									
									<input type="checkbox" onchange="this.setAttribute('.$selectS.', '.$selectS.');" value="'.$tags[$i].'" select="">
									<div class="checkmark">
										
									</div>

								</div>

								<div class="label">
									<span style="color: gray;font-size: 13px;">'.$tags[$i].'&nbsp;&nbsp;</span>
								</div>

							</div>

						</label>';

							}

						?>

					</div>							

					</div>

					<br>

					<div class="birthday">
						
						<label style="font-size: 14px;color: white;position: relative;left: 5px;padding-right: 5px;">Birthday: </label>	
						
						<select class='border: 1px solid white;color:white;background:transparent;' name="day" onchange="document.querySelector('.birthday select[name=day]').setAttribute('value', this.value);"><option value="0" selected="1">Day</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>

						<select name="month" onchange="document.querySelector('.birthday select[name=month]').setAttribute('value', this.value);"><option value="0" selected="1">Month</option><option value="1">Jan</option><option value="2">Feb</option><option value="3">Mar</option><option value="4">Apr</option><option value="5">May</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Aug</option><option value="9">Sept</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select>

						<select name="year" onchange="document.querySelector('.birthday select[name=year]').setAttribute('value', this.value);"><option value="0" selected="1">Year</option><option value="2019">2019</option><option value="2018">2018</option><option value="2017">2017</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option></select>

					</div>

					<br>

					<div class="password">
						
						<input type="password" placeholder="Type in a Password" class="input" autocomplete="false" spellcheck="false" onfocus="signupInputFocus('password')" onfocusout="removeSignupInputFocus('password')" required>
						
						<div class="highlighter"><i style="color: white;" class="far fa-lock"></i></div>

					</div>

					<br>					

					<p style="margin-left: 5px;font-size: 12px;color: gray;">By clicking Sign Up, you agree to our <a href="/terms" target="_blank">Terms</a> and <br> Cookie Policy.</p>

					<br>

					<button id='signup_btn' disabled="true" style="cursor: auto;">Sign Up</button>

					<br>

					<!-- <div class="scroll" onclick="scrollup_signup()">
						<i class="far fa-chevron-up"></i>
					</div>	

					<div class="scroll_down" onclick="scrolldown_signup()">
						<i class="far fa-chevron-down"></i>
					</div> -->

				</form>

				<br>

			</div>

		</div>

	</div>


	</div>
	

	<script src="static-assets/scripts/login.js"></script>

</body>
</html>