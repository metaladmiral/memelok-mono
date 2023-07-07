
var getcidinterval;
var updatelmesinterval;
var loadchatinterval;
var loadchathistoryinterval;
var updateconteinterval;

function getFriendRequestsCount(e) {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200) {
            var resp = this.responseText;
            if(e!=undefined) {
                if(resp!=localStorage.getItem('freqs_count')) {
                    document.querySelector('#ico1 i').classList.add('active');
                }	
            }

            localStorage.setItem('freqs_count', resp);
        }
    }
    let fd = new FormData();
    xml.open('GET', './api/friendRequests/getFriendRequestsCount');
    xml.withCredentials = true;
    xml.send();
}

setInterval(function(){getFriendRequestsCount(1);}, 6500);

function updateUserDetails() {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.status=200 && this.readyState==4) {
            var resp = this.responseText;
            var json = JSON.parse(resp);

            if(json.noti_count>json.oldnoticount) {
                document.querySelector('#ico2 i').classList.add('active');
            }
            localStorage.setItem('mypagesarr', json.mypagesarr);
            localStorage.setItem('pagesfollowing', json.pagesfollowing);
            localStorage.setItem('friends', json.friends);
        }
    }

    var state = document.querySelector('.left_divider .top_heading').getAttribute('state');
    var formdata = new FormData();
    formdata.append('state', state);
    xml.open("POST", "/api/userOperations/get-user-details");
    xml.withCredentials = true;
    xml.send(formdata);
}
updateUserDetailsInterval = setInterval(function(){
    updateUserDetails();
}, 5000);

function hover_ico(e) {
    if(e=='ico1') {
        var dom = document.querySelector('#ico1');
        var dom_ico = document.querySelector('#ico1 i');
        var dom_hg = document.querySelector('#ico1 .hghlgtr');
    }
    else if(e=='ico2') {
        var dom = document.querySelector('#ico2');
        var dom_ico = document.querySelector('#ico2 i');
        var dom_hg = document.querySelector('#ico2 .hghlgtr');
    }
    else {
        var dom = document.querySelector('#ico3');
        var dom_ico = document.querySelector('#ico3 i');
        var dom_hg = document.querySelector('#ico3 .hghlgtr');
    }

    dom_ico.style.color = "var(--hover-color)";
    dom_hg.style.background = "var(--hover-color)";

}

function remove_hover_ico(e) {	
    if(e=='ico1') {
        var dom = document.querySelector('#ico1');
        var dom_ico = document.querySelector('#ico1 i');
        var dom_hg = document.querySelector('#ico1 .hghlgtr');
    }
    else if(e=='ico2') {
        var dom = document.querySelector('#ico2');
        var dom_ico = document.querySelector('#ico2 i');
        var dom_hg = document.querySelector('#ico2 .hghlgtr');
    }
    else {
        var dom = document.querySelector('#ico3');
        var dom_ico = document.querySelector('#ico3 i');
        var dom_hg = document.querySelector('#ico3 .hghlgtr');
    }

    dom_ico.style.color = "rgba(0, 0, 0, 0.5)";
    dom_hg.style.background = "gray";
}	



window.addEventListener('keydown', function(e) {
    if(e.keyCode==27) {
        document.querySelector('.overlay').style.display = "none";
    }
});


    function loadlazypgsugg() {
        var xml = new XMLHttpRequest();
        document.querySelector('.pgsugg .spinner').style.display = "none";
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                document.querySelector('.pgsugg ul').innerHTML = resp;
            } 
        }
        var formdata = new FormData();
        xml.open("POST", "/api/getPageSuggestions");
        xml.withCredentials = true;
        xml.send(formdata);
    }

    function alertmain(cont) {
        document.querySelector('.alert_main .info_content span').innerHTML = cont;
        document.querySelector('.alert_main').style.display = "block";
        setTimeout(function(){
            document.querySelector('.alert_main').style.display = "none";
        }, 4200);
    }

    function enablebtn() {
        try{
        document.querySelector('.right_2 #editbtn').removeAttribute('disabled');
        document.querySelector('.right_2 #editbtn').style.cursor = 'pointer';
        }
        catch(e) {
            console.error(e);
        }
    }
    
    function open_nav_dropdown(e) {
        var i = "";
        if(e=='freq') {
            var dom = document.querySelector('#ico1');
            var dom_ico = document.querySelector('#ico1 i');
            var dom_hg = document.querySelector('#ico1 .hghlgtr');
            var dom_dropdown = document.querySelector(".freq_dropdown");
            document.querySelector('#ico2').setAttribute('cdata', '1');
            document.querySelector('#ico3').setAttribute('cdata', '1');
            document.querySelector('#ico2').setAttribute('onmouseout', "remove_hover_ico('ico2')");
            document.querySelector('#ico3').setAttribute('onmouseout', "remove_hover_ico('ico3')");
            i="ico1";
            document.querySelector('#ico1 i').classList.remove('active');
            dom_dropdown.style.width = "350px";
            dom_dropdown.style.height = "445px";
        }
        else if(e=='noti') {
            var dom = document.querySelector('#ico2');
            var dom_ico = document.querySelector('#ico2 i');
            var dom_hg = document.querySelector('#ico2 .hghlgtr');
            var dom_dropdown = document.querySelector(".noti_dropdown");
            document.querySelector('#ico1').setAttribute('cdata', '1');
            document.querySelector('#ico3').setAttribute('cdata', '1');
            document.querySelector('#ico1').setAttribute('onmouseout', "remove_hover_ico('ico1')");
            document.querySelector('#ico3').setAttribute('onmouseout', "remove_hover_ico('ico3')");
            i='ico2';
            document.querySelector('#ico2 i').classList.remove('active');
            dom_dropdown.style.width = "350px";
            dom_dropdown.style.height = "395px";
        }
        else {
            var dom = document.querySelector('#ico3');
            var dom_ico = document.querySelector('#ico3 i');
            var dom_hg = document.querySelector('#ico3 .hghlgtr');
            var dom_dropdown = document.querySelector(".usrstngs_dropdown");
            document.querySelector('#ico2').setAttribute('cdata', '1');
            document.querySelector('#ico1').setAttribute('cdata', '1');
            document.querySelector('#ico2').setAttribute('onmouseout', "remove_hover_ico('ico2')");
            document.querySelector('#ico1').setAttribute('onmouseout', "remove_hover_ico('ico1')");
            i='ico3';
        }

        var rect = dom.getBoundingClientRect();
        var rx = (window.innerWidth-rect.x)-(45/2+8);
        dom_dropdown.style.right = rx.toString()+"px";

        /* reset all ---------- */

        document.querySelector('#ico1 i').style.color = "rgba(0, 0, 0, 0.5)";
        document.querySelector('#ico1 .hghlgtr').style.background = "gray";
        document.querySelector(".freq_dropdown").style.display = "none";

        document.querySelector('#ico2 i').style.color = "rgba(0, 0, 0, 0.5)";
        document.querySelector('#ico2 .hghlgtr').style.background = "gray";
        document.querySelector(".noti_dropdown").style.display = "none";

        document.querySelector('#ico3 i').style.color = "rgba(0, 0, 0, 0.5)";
        document.querySelector('#ico3 .hghlgtr').style.background = "gray";
        document.querySelector(".usrstngs_dropdown").style.display = "none";

            /* -------- */

        var c_cdata = parseInt(dom.getAttribute('cdata'));

        if(c_cdata%2==1) {
            dom_ico.style.color = "var(--hover-color)";
            dom_hg.style.background = "var(--hover-color)";
            document.querySelector('.nav_main').style.borderBottom = "2px solid var(--hover-color)";
            var n_cdata = c_cdata+1;
            dom.setAttribute('cdata', n_cdata.toString());
            dom_dropdown.style.display = "block";
            dom.removeAttribute('onmouseout');
            if(i=='ico1') {
                getFriendRequests();
            }
            else if(i=='ico2'){
                load_noti();
                document.querySelector('.noti_dropdown .mcont .bottom .noti_main').innerHTML = "";
            }
        }
        else {
            dom_ico.style.color = "rgba(0, 0, 0, 0.5)";
            dom_hg.style.background = "gray";
            document.querySelector('.nav_main').style.borderBottom = "1px solid rgba(0, 0, 0, 0.20)";
            var n_cdata = c_cdata+1;
            dom.setAttribute('cdata', n_cdata.toString());
            dom_dropdown.style.display = "none";	
            var fun= "remove_hover_ico('"+i+"');";
            dom.setAttribute('onmouseout', fun);
        }

    }
// settings js // 
function signup_ifocus(i) {
    var dom = document.querySelector('.'+i);
    var hgh = document.querySelector('.'+i+' .highlighter');
    hgh.style.background = "var(--hover-color)";
}
function remove_signup_ifocus(i) {
    var dom = document.querySelector('.'+i);
    var hgh = document.querySelector('.'+i+' .highlighter');
    hgh.style.background = "rgba(0, 0, 0, 0.60)";
}

function dp_change() {
    var dom = document.querySelector('#dpchange').files[0];
    if(dom.size<=6291456) {
        document.querySelector('.main_spinner').style.display = "flex";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    document.querySelector('.main_spinner').style.display = "none";
                    if(resp=='nai_er') {	
                        alertmain('The File is not an Image.')
                    }	
                    else if(resp=='isset_er'){
                        alertmain('Server Error! Please Try again later.')
                    }
                    else {
                        document.querySelector('.main_settings .left .dp .img img').setAttribute('src', './data/img_users/'+resp);
                    }
                }, 800);
            }
        }
        var formdata = new FormData();
        formdata.append("file", dom);
        xml.open("POST", "./src/temp/dpchange.temp");
        xml.withCredentials = true;
        xml.send(formdata);
    }
    else {
        alertmain('The File is too Big. (Max-6mB)');
    }
}

function animate_settings_toggle(n) {
    var angle = $('.toggle_settings ul .angle');
    var nn = n;
    n = parseInt(n);

    if(n==4) {
        loadfriends();
    }

    var value;
    if(n==1) {
        value = 15;
    }
    else if(value==2){
        value = 55;
    }
    else {
        value = ((n-1)*40)+15;
    }
    
    angle.animate({top: value}, 180, "swing");
    document.querySelector('.toggle_settings ul li[id="selected"]').setAttribute('id', '');
    
    document.querySelector('.toggle_settings ul li[name="'+n+'"]').setAttribute('id', 'selected');

    document.querySelector('.main_settings .right #selected').setAttribute('id', '');
    document.querySelector('.main_settings .right .right_'+n).setAttribute('id', 'selected');

}
function togglepass(n, c) {
    if(n=='show') {
        if(c=='current') {
            document.querySelector('.current .fa-eye').style.display = "none";
            document.querySelector('.current .fa-eye-slash').style.display = "block";
            document.querySelector('.current input').setAttribute('type', 'text');
        }
        else {
            document.querySelector('.new .fa-eye').style.display = "none";
            document.querySelector('.new .fa-eye-slash').style.display = "block";
            document.querySelector('.new input').setAttribute('type', 'text');
        }
    }
    else {
        if(c=='current') {
            document.querySelector('.current .fa-eye').style.display = "block";
            document.querySelector('.current .fa-eye-slash').style.display = "none";
            document.querySelector('.current input').setAttribute('type', 'password');
        }
        else {
            document.querySelector('.new .fa-eye').style.display = "block";
            document.querySelector('.new .fa-eye-slash').style.display = "none";
            document.querySelector('.new input').setAttribute('type', 'password');
        }
    }
}



function agechk(date, month, year) {
    var obj = new Date();

    var curr_date = obj.getDate();
    var curr_month = obj.getMonth()+1;
    var curr_year = obj.getFullYear();

    if((curr_year-year)>10) {
        return 1;
    }
    else if((curr_year-year)==10 && (curr_date-date)>=0 && (curr_month-month)>=0){
        return 1;
    }
    else {
        return 0;
    }

}

function updateUser() {
    document.querySelector(".main_spinner").style.display = "flex";
    var username = document.querySelector('.right_1 .username input').value;
    var bio = document.querySelector('.right_1 .bio textarea').value;
    var day = document.querySelector('.right_1 .birthday select[name=day]').value.toString();
    var month = document.querySelector('.right_1 .birthday select[name=month]').value.toString();
    var year = document.querySelector('.right_1 .birthday select[name=year]').value.toString();
    var birthday = day+"/"+month+"/"+year;

    if(agechk(day, month, year)) {

        var toupdateusername = document.querySelector('.right_1 .username input').getAttribute('toupdate');

        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    document.querySelector(".main_spinner").style.display = "none";
                    alertmain("Account Updated!");
                }, 300);
            }
        }
        var formdata = new FormData();
        formdata.append("username", username);
        formdata.append("bio", bio);
        formdata.append("birthday", birthday);
        formdata.append("toupdateusername", toupdateusername);
        formdata.append("which", "general");
        xml.open("POST", "./api/userOperations/update-user");
        xml.withCredentials = true;
        xml.send(formdata);

    }
    else{
        document.querySelector(".main_spinner").style.display = "none";
        alertmain('Your age should be atleast 10 years.');
    }

}

function updatesocial() {
    var facebook = document.querySelector('.right_2 .facebook input').value;
    var instagram = document.querySelector('.right_2 .instagram input').value;
    var twitter = document.querySelector('.right_2 .twitter input').value;
    document.querySelector(".main_spinner").style.display = "flex";

    var xml=new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200) {
            var resp = this.responseText;
            if(resp=='1') {
                setTimeout(function(){
                    document.querySelector(".main_spinner").style.display = "none";
                    alertmain("Your social media accounts are Updated!");						
                }, 500);
            }
            else {
                console.log(resp);
            }
        }
    }
    var formdata = new FormData();
    formdata.append('facebook', facebook);
    formdata.append('instagram', instagram);
    formdata.append('twitter', twitter);
    formdata.append('which', 'social')
    xml.open("POST", "./src/actions/update_user");
    xml.withCredentials = true;
    xml.send(formdata);
}

function password_btn_toggle() {
    var passlen = document.querySelector('.right_3 .new input').value.length;
    if(passlen>=8) {
        document.querySelector('.right_3 .change_pass_btn').removeAttribute('disabled');
        document.querySelector('.right_3 .change_pass_btn').style.cursor = 'pointer';
    }
    else {
        document.querySelector('.right_3 .change_pass_btn').setAttribute('disabled', 'true');
        document.querySelector('.right_3 .change_pass_btn').style.cursor = 'auto';	
    }
}

function updatepassword() {
    var current_pass = document.querySelector(".right_3 .current input").value;
    var new_pass = document.querySelector(".right_3 .new input").value;
    document.querySelector('.main_spinner').style.display = "flex";

    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200) {
            var resp = this.responseText;
            setTimeout(function(){
                document.querySelector('.main_spinner').style.display = "none";
                if(resp=='1') {
                    alertmain("Password Changed!");
                }						
                else if(resp=='no'){
                    alertmain("Current Password is wrong!");
                }
                else {
                    alertmain("Server Error! Please try again later.");
                }
            }, 650);
        }
    }	
    var formdata = new FormData();
    formdata.append('current', current_pass);
    formdata.append('new', new_pass);
    formdata.append('which', 'security');
    xml.open("POST", "./src/actions/update_user");
    xml.withCredentials = true;
    xml.send(formdata);	

}

function loadfriends(offset, withload) {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.status==200 && this.readyState==4) {
            var resp = this.responseText;
            document.querySelector('.right_4 .bottom .loader').style.display = "none";
            try {
                var json = JSON.parse(resp);
                document.querySelector('.right_4 .top h1 span').innerHTML = "("+json.count+")";
                setTimeout(function(){
                    if(withload==undefined) {
                        document.querySelector('.right_4 .bottom .main').innerHTML = json.data;
                    }
                    else {
                        document.querySelector('.right_4 .bottom .main').innerHTML += json.data;
                    }
                }, 250);
            }
            catch(err) {
                document.querySelector('.right_4 .top h1 span').innerHTML = "(0)";
                document.querySelector('.right_4 .bottom .main').innerHTML = resp;
            }
        }
    }
    var formdata = new FormData();
    if(offset==undefined) {
        formdata.append('offset', 0);
    }
    else {
        formdata.append('offset', offset);
    }
    formdata.set("friends", localStorage.getItem('friends'));
    xml.open("POST", "/api/userOperations/get-my-friends");
    xml.withCredentials = true;
    xml.send(formdata);

}

function unfriendUser(friendUid, id) {
    var spinner = document.querySelector('#id'+id+' .spinner');
    var icon = document.querySelector('#id'+id+' i');
    spinner.style.display = "block";
    icon.style.display = "none";

    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200) {
            var resp = this.responseText;
            
            if(resp==1) {
                setTimeout(function(){
                    document.querySelector('#id'+id+' .unfriend_confirm').style.display = "block";
                    spinner.style.display = "none";
                }, 500);
            }
            else {
                spinner.style.display = "none";
                alertmain('An error Occured!');
                console.log(resp);
            }

        }
    }
    var formdata = new FormData();
    formdata.append('friendUid', friendUid);
    xml.open("POST", "./api/userOperations/unfriend");
    xml.withCredentials = true;
    xml.send(formdata);
}

// settings js ends //

// Create Page //

function upload_temp_page_dp() {
    var dom = document.querySelector('.bottom_maincreatepage form .dps input').files[0];
    if(dom.size<=6291456) {
        document.querySelector('.bottom_maincreatepage .dps .spinner').style.display = "block";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    document.querySelector('.bottom_maincreatepage .dps .spinner').style.display = "none";
                    if(resp=='nai_er') {	
                        alertmain('The File is not an Image.')
                    }	
                    else if(resp=='isset_er'){
                        alertmain('Server Error! Please Try again later.')
                    }
                    else {
                        document.querySelector('.bottom_maincreatepage form .dps input').setAttribute('src', resp);
                        document.querySelector('.bottom_maincreatepage form .dps .upload img').setAttribute('src', './data/temp_uploads/'+resp);
                        document.querySelector('.bottom_maincreatepage form .dps .upload img').style.display = "block";
                        document.querySelector('.bottom_maincreatepage form .dps .upload').setAttribute('class', 'upload upload-after');
                        document.querySelector('.bottom_maincreatepage form .dps .upload').setAttribute('upload-after-text', 'Click to Change');
                    }
                }, 800);
            }
        }
        var formdata = new FormData();
        formdata.append("file", dom);
        xml.open("POST", "./src/temp/imageupload.temp");
        xml.withCredentials = true;
        xml.send(formdata);
    }
    else {
        alertmain('The File is too Big. (Max-6mB)');
    }
}		

function createpage() {
    var name = document.querySelector('.bottom_maincreatepage form .page_name input').value;
    var email = document.querySelector('.bottom_maincreatepage form .page_email input').value;
    var facebook = document.querySelector('.bottom_maincreatepage form .facebook input').value;
    var instagram = document.querySelector('.bottom_maincreatepage form .instagram input').value;
    var twitter = document.querySelector('.bottom_maincreatepage form .twitter input').value;
    var pic = document.querySelector('.bottom_maincreatepage form .dps input').getAttribute('src');
    var about = document.querySelector('.bottom_maincreatepage form .page_about textarea').value;

    document.querySelector('.main_spinner').style.display = "flex";

    if(about=='') {
        about = '-';
    }

    if(pic=='') {
        pic = '-';
    }

    if(facebook=='') {
        facebook = '-';
    }

    if(instagram=='') {
        instagram = '-';
    }

    if(twitter=='') {
        twitter = '-';
    }

    if(name=='' || email=='') {
        alertmain("Please fill the name and email entries.");
    }else {
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;

                setTimeout(function(){
                    document.querySelector('.main_spinner').style.display = "none";
                    if(resp=='email_err') {
                        alertmain("Please enter a real email.");
                    }
                    else if(resp=='err') {
                        alertmain("Please try again later.");
                    }
                    else if(resp=='nemail_err') {
                        alertmain("Page with same email already exists.");
                    }
                    else if(resp=='char_err') {
                        alertmain("Page Name should not contain spaces or special letters.");
                    }
                    else if(resp=='len_err') {
                        alertmain("Pagename length should be greator than 4 and less than 19.");
                    }
                    else if(resp=='1'){
                        alertmain("Your Page has been created.");
                    }
                    else {
                        console.log(resp);
                        alertmain("Server Error! Please Try again later.");
                    }
                }, 700);						
            }
        }
        var formdata = new FormData();
        formdata.append('name', name);
        formdata.append('email', email);
        formdata.append('facebook', facebook);
        formdata.append('instagram', instagram);
        formdata.append('twitter', twitter);
        formdata.append('pic', pic);
        formdata.append('about', about);
        xml.open("POST", "./api/pageOperations/create-page");
        xml.withCredentials = true;
        xml.send(formdata);
    }

    return false;

}

// Create Page ends //


// My Pages //

function open_mypageedit(which, dp, name, post_count, followers, about, social, email) {
    document.querySelector('.settings_mypages_overlay').style.display = "block";
    document.querySelector('.settings_mypages_overlay').setAttribute('which', which);
    document.querySelector('.settings_mypages_overlay .main .top span h2 span').innerHTML = "("+decodeURI(name)+")";
    document.querySelector('.settings_mypages_overlay .main .bottom .name input').setAttribute('value', decodeURI(name));
    document.querySelector('.settings_mypages_overlay .main .bottom .about textarea').innerHTML = decodeURIComponent(about);
    document.querySelector('.settings_mypages_overlay .main .bottom .email input').setAttribute('value', decodeURIComponent(email));

    social = JSON.parse(decodeURIComponent(social));
    var fb = social.facebook;
    var instagram = social.instagram;
    var twitter = social.twitter;

    document.querySelector('.settings_mypages_overlay .main .bottom .social .facebook input').setAttribute('value', fb);
    document.querySelector('.settings_mypages_overlay .main .bottom .social .instagram input').setAttribute('value', instagram);
    document.querySelector('.settings_mypages_overlay .main .bottom .social .twitter input').setAttribute('value', twitter);

    if(dp=='-') {
        document.querySelector('.settings_mypages_overlay .main .bottom .dp .img img').setAttribute('src', './data/img_pages/yellow.jpg');
    }
    else {
        document.querySelector('.settings_mypages_overlay .main .bottom .dp .img img').setAttribute('src', './data/img_pages/'+dp);
    }

}

function updatepageinfo(which) {
    document.querySelector('.main_spinner').style.display = "flex";
    var name = document.querySelector('.settings_mypages_overlay .main .bottom .name input').value;
    var about = document.querySelector('.settings_mypages_overlay .main .bottom .about textarea').value;
    var photo = document.querySelector('.settings_mypages_overlay .main .bottom .dp .img img').getAttribute('src');
    var email = document.querySelector('.settings_mypages_overlay .main .bottom .email input').value;

    var fb = document.querySelector('.settings_mypages_overlay .main .bottom .social .facebook input').value;
    var twitter = document.querySelector('.settings_mypages_overlay .main .bottom .social .twitter input').value;
    var instagram = document.querySelector('.settings_mypages_overlay .main .bottom .social .instagram input').value;

    if(fb=='') {
        fb = '-';
    }

    if(twitter=='') {
        twitter == '-';
    }

    if(instagram=='') {
        instagram = '-';
    }

    if(photo.includes("yellow.jpg")) {
        photo = "-";
    }

    var social = {facebook: fb, twitter: twitter, instagram: instagram};
    social = JSON.stringify(social);

    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.status==200 && this.readyState==4) {
            var resp = this.responseText;
            document.querySelector('.main_spinner').style.display = "none";
            if(resp=='1') {
                alertmain("Done!");
                setTimeout(function(){
                    document.querySelector('.settings_mypages_overlay').style.display = 'none';
                }, 1000);
            }
            else {
                alertmain(resp);
            }
        }
    }
    var formdata = new FormData();
    formdata.append("name", name);
    formdata.append("about", about);
    formdata.append("photo", photo);
    formdata.append("email", email);
    formdata.append("social", social);
    formdata.append("pid", which);
    xml.open("POST", "./api/pageOperations/update-mypage-info");
    xml.withCredentials = true;
    xml.send(formdata);

}

function dp_change_page() {
    var dom = document.querySelector('#dpchangepage').files[0];
    if(dom.size<=6291456) {
        document.querySelector('.main_spinner').style.display = "flex";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    document.querySelector('.main_spinner').style.display = "none";
                    if(resp=='nai_er') {	
                        alertmain('The File is not an Image.')
                    }	
                    else if(resp=='isset_er'){
                        alertmain('Server Error! Please Try again later.')
                    }
                    else {
                        document.querySelector('.settings_mypages_overlay .main .bottom .dp .img img').setAttribute('src', './data/temp_uploads/'+resp);
                    }
                }, 800);
            }
        }
        var formdata = new FormData();
        formdata.append("file", dom);
        xml.open("POST", "./src/temp/dpchangepage.temp");
        xml.withCredentials = true;
        xml.send(formdata);
    }
    else {
        alertmain('The File is too Big. (Max-6mB)');
    }
}

function load_mypages() {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200) {
            var resp = this.responseText;
            if(resp=='0') {
                setTimeout(function(){
                    document.querySelector(".main_mypages .bottom .spinner_").style.display = "none"
                    document.querySelector(".main_mypages .bottom .items").innerHTML = "<span style='position: absolute;left: 50%;color: gray;text-align: center;top: 10px;transform: translate(-50%, 0%)'>You do not have any page.</span>";
                }, 300);
            }
            else {
                setTimeout(function(){
                    document.querySelector(".main_mypages .bottom .spinner_").style.display = "none"
                    document.querySelector(".main_mypages .bottom .items").innerHTML = resp;
                }, 300);
            }
        }
    }
    xml.open("POST", "./api/pageOperations/load-mypages");
    xml.withCredentials=true;
    xml.send();
}

function open_uploadpost_overlay(which, name, pc, pagedp) {
    document.querySelector('.upload_post_overlay').style.display = "block";
    document.querySelector('.upload_post_overlay').setAttribute('which', which);
    document.querySelector('.upload_post_overlay').setAttribute('name', name);
    document.querySelector('.upload_post_overlay').setAttribute('pc', pc);
    document.querySelector('.upload_post_overlay').setAttribute('pagedp', pagedp);
}

function uploadmemeimage() {
    var dom = document.querySelector('#memeuploadinput').files[0];
    if(dom.size<=6291456) {
        document.querySelector('.uploadimage .iconcontainer .spinner').style.display = "block";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    document.querySelector('.uploadimage .iconcontainer .spinner').style.display = "none";
                    if(resp=='nai_er') {	
                        alertmain('The File is not an Image.');
                        document.querySelector('.upload_post_overlay .main .top button').setAttribute('disabled', 'true');
                        document.querySelector('.upload_post_overlay .main .top button').style.cursor = "auto";
                    }	
                    else if(resp=='isset_er'){
                        alertmain('Server Error! Please Try again later.');
                        document.querySelector('.upload_post_overlay .main .top button').setAttribute('disabled', 'true');
                        document.querySelector('.upload_post_overlay .main .top button').style.cursor = "auto";
                    }
                    else {
                        $('.uploadimage').animate({top: "10px"}, "fast", "linear");

                        document.querySelector('.uploadimage .iconcontainer i').setAttribute('class', 'far fa-exchange');
                        document.querySelector('.uploadimage #infoupload').innerHTML = "Click to Change";
                        document.querySelector('.imagecontainer').style.display = "block";
                        document.querySelector('.imagecontainer img').setAttribute('src', "./data/temp_uploads/"+resp); 
                        document.querySelector('.upload_post_overlay .main .top button').removeAttribute('disabled');
                        document.querySelector('.upload_post_overlay .main .top button').style.cursor = "pointer";
                    }
                }, 800);
            }
        }
        var formdata = new FormData();
        formdata.append("file", dom);
        xml.open("POST", "./src/temp/memeimageupload.temp");
        xml.withCredentials = true;
        xml.send(formdata);
    }
    else {
        alertmain('The File is too Big. (Max-6mB)');
    }	
}

function addtagstoggle() {
    document.querySelector('.upload_post_overlay .bottom .right .addtagsinfo').style.display = "none";
    document.querySelector('.upload_post_overlay .bottom .right .addtags_container').style.display = "block";
    document.querySelector('.upload_post_overlay .bottom .right .addtags').style.display = "block";
}

function uploadmeme() {
    //.upload_post_overlay > which
    //.imagecontainer img > src
    var tags = [];
    var tagslen = $('.addtags input[type=checkbox]:checked').length;
    var i;
    if(tagslen>0) {
        var stags = $('.addtags input[type=checkbox]:checked');
        var value;
        for(i=0;i<=tagslen-1;i++) {
            value = stags[i].value;
            tags.push(value);
        }
    }
    else {
        tags = [];
    }

    var img = document.querySelector('.imagecontainer img').getAttribute('src');
    var which = document.querySelector('.upload_post_overlay').getAttribute('which');
    var caption = document.querySelector('.upload_post_overlay .right .caption textarea').value;
    var pagename = document.querySelector('.upload_post_overlay').getAttribute('name');
    var pc = document.querySelector('.upload_post_overlay').getAttribute('pc');

    var pagedp = document.querySelector('.upload_post_overlay').getAttribute('pagedp');

    document.querySelector('.upload_post_overlay .main .top .spinner').style.display = "block";

    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.status==200 && this.readyState==4) {
            var resp = this.responseText;
            setTimeout(function(){
                document.querySelector('.upload_post_overlay .main .top .spinner').style.display = "none";

                if(resp==1) {
                    alertmain("Upload Complete!");
                }
                else {
                    alertmain("Server Error! Please Try again Later.");
                    console.log(resp);
                }

                document.querySelector('.overlay').innerHTML = "";
                document.querySelector('.overlay').style.display = "none";
                document.querySelector('.uploadimage .iconcontainer i').setAttribute('class', 'far fa-arrow-alt-up');
                document.querySelector('.uploadimage #infoupload').innerHTML = "(Only JPEG, PNG or JPG)";
                document.querySelector('.imagecontainer').style.display = "none";
                document.querySelector('.upload_post_overlay .main .top button').setAttribute('disabled', 'true');
                document.querySelector('.upload_post_overlay .main .top button').style.cursor = "auto";
                document.querySelector('.imagecontainer img').setAttribute('src', "");


                document.querySelector('.upload_post_overlay').style.display = "none";
                document.querySelector('.upload_post_overlay').removeAttribute('which');
                document.querySelector('.upload_post_overlay').removeAttribute('name');
                document.querySelector('.upload_post_overlay').removeAttribute('pc');
                document.querySelector('.upload_post_overlay').removeAttribute('pagedp');


            }, 500);
        }
    }
    var formdata = new FormData();
    formdata.append('which', which);
    formdata.append('img', img);
    formdata.append('tags', JSON.stringify(tags));
    formdata.append('pagename', pagename);
    formdata.append('pc', pc);
    formdata.append('pagedp', pagedp);
    if(caption) {
        formdata.append('caption', caption);
    }
    xml.open("POST", "/api/postOperations/upload-post");
    xml.withCredentials = true;
    xml.send(formdata);

}

// ----------------------------------------------- //


/* main */

function download_post(pgname, imagelink) {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.readyState==4 && this.status==404) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if(this.readyState==4 && this.status==200) {
                    document.querySelector('.downloadmeme').setAttribute('href', './data/img_watermarked/');
                    document.querySelector('.downloadmeme').setAttribute('download', imagelink);
                    /*document.querySelector('.downloadmeme').click();*/
                }
            }
            xhr.open("GET", "http://localhost:5000/labelimage?pname="+pgname+"&imlink="+imagelink);
            xhr.send();
        }
        else if(this.readyState==4 && this.status==200){
            document.querySelector('.downloadmeme').setAttribute('href', './data/img_watermarked/');
            document.querySelector('.downloadmeme').setAttribute('download', imagelink);
            /*document.querySelector('.downloadmeme').click();*/
        }
    }
    xml.open("GET", "./data/img_watermarked/"+imagelink);
    xml.send();

}

function slidedrop_post(dom, id) {
    var data = parseInt(dom.getAttribute('dataclick'));

    if(data%2==0) {
        document.querySelector('#f'+id+' .top .extraicon i').style.color = 'var(--hover-color)';
        document.querySelector('#f'+id+' .top .extraicon i').style.fontWeight = 'bolder';
        document.querySelector('#f'+id+' .top .extraicon i').style.fontSize = '18px';
        document.querySelector('#f'+id+' .top').style.borderBottom = "2px solid var(--hover-color)";
        document.querySelector('#f'+id+' .top .pdp').style.border = "2px solid var(--hover-color)";
        $('#drop_'+id).slideDown(200, 'swing');
        dom.setAttribute('dataclick', '1');
    }
    else {
        document.querySelector('#f'+id+' .top .extraicon i').style.color = '#222';
        document.querySelector('#f'+id+' .top .extraicon i').style.fontWeight = 'bold';
        document.querySelector('#f'+id+' .top .extraicon i').style.fontSize = '16px';
        document.querySelector('#f'+id+' .top').style.borderBottom = "1px solid var(--main-border)";
        document.querySelector('#f'+id+' .top .pdp').style.border = "1px solid var(--main-border)";
        $('#drop_'+id).slideUp("fast");
        dom.setAttribute('dataclick', '0');	
    }

}

function unfollowpage_thrposts(which, id) {
    document.querySelector('#f'+id+' .top .extraicon i').style.color = '#222';
    document.querySelector('#f'+id+' .top .extraicon i').style.fontWeight = 'bold';
    document.querySelector('#f'+id+' .top .extraicon i').style.fontSize = '16px';
    document.querySelector('#f'+id+' .top').style.borderBottom = "1px solid var(--main-border)";
    document.querySelector('#f'+id+' .top .pdp').style.border = "1px solid var(--main-border)";
    $('#drop_'+id).slideUp("fast");
    document.querySelector('#f'+id+" .top .extraicon i").setAttribute('dataclick', '0');	

    var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    if(resp==1) {
                        alertmain("Unfollowed!");
                    }	
                    else if(resp==0){
                        alertmain('An error occured.');
                    }
                    else {
                        alertmain(resp);
                    }
                }, 40);
            }
        }
        var formdata = new FormData();
        formdata.append("pid", which);
        formdata.append('statechangetype', 'unfollow');
        xml.open("POST", "./api/pageOperations/follow-state-change");
        xml.withCredentials = true;
        xml.send(formdata);	

}

function followpage_thrposts(which, id) {
    document.querySelector('#f'+id+' .top .extraicon i').style.color = '#222';
    document.querySelector('#f'+id+' .top .extraicon i').style.fontWeight = 'bold';
    document.querySelector('#f'+id+' .top .extraicon i').style.fontSize = '16px';
    document.querySelector('#f'+id+' .top').style.borderBottom = "1px solid var(--main-border)";
    document.querySelector('#f'+id+' .top .pdp').style.border = "1px solid var(--main-border)";
    $('#drop_'+id).slideUp("fast");
    document.querySelector('#f'+id+" .top .extraicon i").setAttribute('dataclick', '0');	

    var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    if(resp==1) {
                        alertmain("Followed!");
                    }	
                    else if(resp==0){
                        alertmain('An error occured.');
                    }
                    else {
                        alertmain(resp);
                    }
                }, 40);
            }
        }
        var formdata = new FormData();
        formdata.append("pid", which);
        formdata.append('statechangetype', 'follow');
        xml.open("POST", "./api/pageOperations/follow-state-change");
        xml.withCredentials = true;
        xml.send(formdata);	

}

function reacttopost(which, mid, domid) {
    if(which=='positive') {
        document.querySelector('#f'+domid+' .post_actions .left i').setAttribute('id', 'animatepositive');
        document.querySelector('#f'+domid+' .post_actions .left span').style.fontWeight = "bold";
        document.querySelector('#f'+domid+' .post_actions .left span').style.color = "var(--hover-color)";
        document.querySelector('#f'+domid+' .post_actions .left span').style.fontSize = "13px";	

    }
    else {

    }

    if(which=='positive') {
        var count = parseInt(document.querySelector('#f'+domid+' .post_actions #like_count').getAttribute('data-react'));
        count += 1;
        document.querySelector('#f'+domid+' .post_actions #like_count').setAttribute('data-react', count.toString());
        document.querySelector('#f'+domid+' .post_actions #like_count').innerHTML = "("+count.toString()+")";
        
        document.querySelector('#f'+domid+' .post_actions .left').removeAttribute('onclick');
        document.querySelector('#f'+domid+' .post_actions .left').style.cursor = "auto";

        document.querySelector('#f'+domid+' .post_actions .right').removeAttribute('onclick');
        document.querySelector('#f'+domid+' .post_actions .right').style.cursor = "auto";
    }
    else {
        var count = parseInt(document.querySelector('#f'+domid+' .post_actions #dislike_count').getAttribute('data-react'));
        count += 1;
        document.querySelector('#f'+domid+' .post_actions #dislike_count').setAttribute('data-react', count.toString());
        document.querySelector('#f'+domid+' .post_actions #dislike_count').innerHTML = "("+count.toString()+")";

        document.querySelector('#f'+domid+' .post_actions .left').removeAttribute('onclick');
        document.querySelector('#f'+domid+' .post_actions .left').style.cursor = "auto";

        document.querySelector('#f'+domid+' .post_actions .right').removeAttribute('onclick');
        document.querySelector('#f'+domid+' .post_actions .right').style.cursor = "auto";

    }

    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.status==200 && this.readyState==4) {
            var resp = this.responseText;
            if(resp=='1') {

            }
            else {
                console.log(resp);
                alertmain("Couldn't react to the post");
            }
        }
    }
    var formdata = new FormData();
    formdata.append("mid", mid);
    formdata.append("reacttype", which);
    xml.open("POST", "/api/postOperations/react-to-post");
    xml.withCredentials = true;
    xml.send(formdata);
}

/* ------------------------------------------ */

/* CHAT */

function loadlazychat() {
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function() {
        if(this.readyState == 4 && this.status==200) {
            var resp = this.responseText;
            try {
                resp = JSON.parse(resp);
                var count = resp['count'];
                var data = resp['data'];

                try {
                    document.querySelector('.onnfrnds').innerHTML = data;
                    if(document.querySelector('.onlinefrnds #line').getAttribute('data-value').includes('On')) {

                        document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Online Friends ('+count+')');
                        document.querySelector('.onlinefrnds #line').setAttribute('f_count', count);
                    }
                    else {

                    }
                }
                catch(err) {

                }	
            }
            catch(err) {
                document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Online Friends (0)');
                document.querySelector('.onnfrnds').innerHTML = resp;
            }

            document.querySelector("#offonchatspin").style.display = "none";							
        }
    }
    xml.open("POST", "/api/getOnlineFriends");
    xml.withCredentials = true;
    xml.send();
}

function chatanimation() {
        document.querySelector('.onlinefrnds #line').setAttribute("class", "anim");

        setTimeout(function() {
            document.querySelector('.onlinefrnds #line').setAttribute("class", "");
        }, 900);		

        var changedata = parseInt(document.querySelector('.onlinefrnds #line').getAttribute('data-change'));

        if(changedata%2==1) {
            document.querySelector('.onnfrnds').style.display = "none";
            document.querySelector('#offonchatspin').style.display = "block";
            setTimeout(function() {
                document.querySelector('#offonchatspin').style.display = "none";
                document.querySelector('.chathistory').style.display = "block";	
                document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Chat History');
            }, 1250);

            clearInterval(loadchatinterval);

            loadchathistory(0, 12, null);
            document.querySelector('.chatwindow').setAttribute('data-which', 'history');

            try {
                document.querySelector('.right_more_ i').removeAttribute('id');
            }
            catch(err) {

            }
        }	
        else {
            document.querySelector('.onnfrnds').style.display = "block";
            document.querySelector('.chathistory').style.display = "none";
            document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Online Friends (0)');
            var state = document.querySelector('.left_divider .top_heading').getAttribute('state');

            clearInterval(loadchathistoryinterval);

            if(state=='enabled') {

                loadchatinterval = setInterval(function(){
                    loadlazychat();
                }, 2500);
                document.querySelector('.chatwindow').setAttribute('data-which', 'chat');
            }
            else {

            }
        }

        changedata += 1;

        document.querySelector('.onlinefrnds #line').setAttribute('data-change', changedata.toString());

    }

    function disablechat() {
        var data = document.querySelector('.left_more_').getAttribute('cdata');
        if(parseInt(data)%2==1) {
            clearInterval(loadchatinterval);
            document.querySelector('.onnfrnds').innerHTML = "";
            document.querySelector('#offonchatspin').style.display = "block";

            document.querySelector('.left_divider .top_heading').setAttribute('state', 'disabled');


            setTimeout(function() {
                document.querySelector('.center_more_').style.color = "#cc0000";
                document.querySelector('#offonchatspin').style.display = "none";
                document.querySelector('.onnfrnds').innerHTML = "";
                document.querySelector('.onnfrnds').innerHTML = "<span class='chat_off_warning'><br><h1>You are Offline!</h1><br><font style='color: #262626'>Click the power button</font> <br> <i class='fas fa-power-off fa-4x' style='position: relative;top:2px;color: #262626'></i> <br> <font style='position: relative;top: 4px;'>to enable Chat.</font></span>";
                document.querySelector('.onnfrnds').innerHTML = "<img src='./static-assets/img/panda_offline3.jpg' width='260' height='260'>";
                document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Online Friends (0)');
            }, 2001);
        }
        else {

            document.querySelector('#offonchatspin').style.display = "block";
            document.querySelector('.onnfrnds').innerHTML = "";

            document.querySelector('.left_divider .top_heading').setAttribute('state', 'enabled');


            setTimeout(function(){
                document.querySelector('.center_more_').style.color = "#00b300";
                loadchatinterval = setInterval(function(){loadlazychat();}, 2500);
            }, 1500);
        }
        var newdata = parseInt(data)+1;
        document.querySelector('.left_more_').setAttribute('cdata', newdata.toString());
    }

    function loadchathistory(offset, limit,total) {
        offset = parseInt(offset);
        limit = parseInt(limit);
        if(total==null) {

        }
        else {
            total = parseInt(total);
        }

        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.status==200 && this.readyState==4) {
                var resp = this.responseText;
                if(resp==0) {
                    document.querySelector('.chathistory').innerHTML = "<center><span style='font-size:12px;color: gray;'>You haven't started a conversation with anyone yet.</span></center>";
                }
                else {
                    document.querySelector('.chathistory').innerHTML = resp;
                    loadchathistoryinterval = setInterval(function(){loadchathistorytchk(0, 12, null);}, 2500);
                }
            }
        }
        xml.open("GET", "./src/chat/loadchathistory?offset="+offset+"&limit="+limit+"&total="+total);
        xml.withCredentials = true;
        xml.send();
    }

    function loadchathistorytchk(offset, limit, total) {
        var xml = new XMLHttpRequest();
        var lastmess = encodeURIComponent(document.querySelector('.item_chat .details ul .last_message').innerHTML);
        xml.onreadystatechange = function() {
            if(this.status==200 && this.readyState==4) {
                var resp = this.responseText;
                if(resp==0) {
                }
                else {
                    resp = JSON.parse(resp);
                    var id = resp["uid"];
                    document.querySelector(".item_chat[uid="+id+"]").remove();
                    var prevdata = document.querySelector('.chathistory').innerHTML;
                    document.querySelector('.chathistory').innerHTML = resp["html"]+prevdata;
                }
            }
        }
        xml.open("GET", "./src/chat/loadchathistory?offset="+offset+"&	limit="+limit+"&total="+total+"&lmess="+lastmess);
        xml.withCredentials = true;
        xml.send();	
    }

    function getFriendRequests(offset, withload) {
        document.querySelector('.freq_dropdown .mcont .bottom .spinner').style.display = "block";
        document.querySelector('.freq_dropdown .mcont .bottom .reqs').innerHTML = "";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange= function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    document.querySelector('.freq_dropdown .mcont .bottom .spinner').style.display = "none";
                    if(withload==undefined) {
                        document.querySelector('.freq_dropdown .mcont .bottom .reqs').innerHTML = resp;
                    }
                    else {
                        document.querySelector('.freq_dropdown .mcont .bottom .reqs').innerHTML += resp;
                    }
                }, 250);
            }
        }
        xml.open("POST", "./api/friendRequests/getFriendRequests");
        xml.withCredentials = true;
        var formdata = new FormData();
        if(offset==undefined) {
            formdata.append('offset', 0);
        }
        else {
            formdata.append('offset', offset);	
        }
        xml.send(formdata);
    }

    function markallnotiread() {
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                if(resp==1) {
                    alertmain("Done!");
                }
                else {
                    alertmain(resp);
                }
            }
        }
        xml.open("POST", "./src/actions/markallnotiread");
        xml.withCredentials = true;
        xml.send();
    }

    function removechatwindow(which) {
        document.querySelector('.chatwindow').style.display = 'none';
        document.querySelector('.chatwindow').setAttribute('data-username', '');
        document.querySelector('.chatwindow').setAttribute('data-fullname', '');
        document.querySelector('.chatwindow').setAttribute('data-cid', '');
        document.querySelector('.chatwindow').setAttribute('data-uid', '');
        document.querySelector('.chatwindow').setAttribute('data-pic', '');
        
        clearInterval(getcidinterval);
        clearInterval(updatelmesinterval);

        if(which=='history') {
            loadchathistory(0, 12, null);
            document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Chat History');	
        }
        else {
            document.querySelector('.onlinefrnds #line').setAttribute('data-value', 'Online Friends ('+document.querySelector('.onlinefrnds #line').getAttribute('f_count')+')');
        }
    
    }	

    function loadchat(uid_f, uid_m, username, offset, limit, allmesscount, rand) {
        document.querySelector('.mainchat .spinner').style.display = "block";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.status==200 && this.readyState==4) {
                var resp = this.responseText;
                document.querySelector('.mainchat .spinner').style.display = "none";
                
                var prevdata = document.querySelector('.mainchat .maindata ul').innerHTML;
                document.querySelector('.mainchat .maindata ul').innerHTML = prevdata+resp;
                try {
                document.querySelector('#'+rand).style.display = 'none';
                }
                catch(err) {

                }	
                document.querySelector('#chat_mess_input').focus();
                document.querySelector('#chat_mess_input').setAttribute('value', '');
            }
        }
        var formdata = new FormData();
        if(offset==undefined) {
            offset = 0;
        }

        if(limit==undefined) {
            limit = 15;
        }

        if(allmesscount==undefined) {
            allmesscount = 0;
        }

        formdata.append('offset', offset);
        formdata.append('limit', limit);
        formdata.append('username', username);
        formdata.append('allmesscount', allmesscount);

        formdata.append("uid_f", uid_f);
        formdata.append("uid_m", uid_m);
        xml.open("POST", "./src/chat/loadchats");
        xml.withCredentials = true;
        xml.send(formdata);
    }

    /* ------------------------------ */


    /* SEARCH ----------- */ 


    function searchbar_toggle(e) {
        if(window.innerWidth>924) {
            document.querySelector('.ico_search').style.display='none';
            document.querySelector('.search_bar').style.display='flex';
        }
        else {
            if(e=='open') {
                var dom = document.querySelector('.ico_search');
                var dom_dropdown = document.querySelector('.search_resp_dropdown');

                document.querySelector('.nav_main').style.borderBottom = "2px solid var(--hover-color)";

                dom_dropdown.style.display = "flex";
                var rect = dom.getBoundingClientRect();
                var rx = (window.innerWidth-rect.x)-(45/2+8);
                dom_dropdown.style.right = rx.toString()+"px";
                dom.setAttribute('onclick', 'searchbar_toggle("close")');
                dom_dropdown.style.width = "285px";
                dom_dropdown.style.height = "60px";
            }
            else {
                var dom = document.querySelector('.ico_search');
                var dom_dropdown = document.querySelector('.search_resp_dropdown');

                document.querySelector('.nav_main').style.borderBottom = "1px solid var(--main-border)";

                dom_dropdown.style.display = "none";
                dom.setAttribute('onclick', 'searchbar_toggle("open")');	
            }
        }
    }


    function focussearchbar() {
        document.querySelector('.search_bar .highlgtr').style.background = "var(--hover-color)"; 
        document.querySelector('.search_resp_dropdown .highlgtr').style.background = "var(--hover-color)"; 
    }

    function focussoutsearchbar() {
        document.querySelector('.search_bar .highlgtr').style.background = "gray";
        document.querySelector('.search_resp_dropdown .highlgtr').style.background = "gray"; 
    }

    function search(val, which, offset, withload) {
        try {
            document.querySelector(".overlay").style.display = "none";
            document.querySelector(".search_resp_dropdown").style.display = "none";
        }
        catch(err) {}
        var xml = new XMLHttpRequest();
        document.querySelector('.main_search .bottom .spinner').style.display = "block";
        document.querySelector('.main_search .bottom .content').innerHTML = "";
        xml.onreadystatechange = function() {
            if(this.status==200 && this.readyState==4) {
                var resp = this.responseText;
                document.querySelector('.search_overlay').style.display = "block";
                setTimeout(function(){
                    document.querySelector('.main_search .bottom .spinner').style.display = "none";
                    if(withload==undefined) {
                        document.querySelector('.main_search .bottom .content').innerHTML = resp;
                    }
                    else {
                        document.querySelector('.main_search .bottom .content').innerHTML += resp;
                    }
                }, 450);
            }
        }
        var formdata = new FormData();
        formdata.set("query", val);
        formdata.set("searchType", which);
        formdata.set("friends", localStorage.getItem("friends"));
        formdata.set("mypagesarr", localStorage.getItem("mypagesarr"));
        formdata.set("pagesfollowing", localStorage.getItem("pagesfollowing"));
        if(offset==undefined) {
            formdata.append('offset', 0);
        }
        else{
            formdata.append('offset', offset);
        }
        xml.open("POST", "./api/search");
        xml.withCredentials = true;
        xml.send(formdata);
    }

    function entercapture(e, dom, value) {
            document.querySelector('.resp_search_input').value = value;
        if(value.length>0) {
            if(e.key=='Enter') {
                search(value, 'people');
                document.querySelector('.typetoggle option[value=people]').removeAttribute('selected');
                document.querySelector('.typetoggle #toggle option[value=people]').setAttribute("selected", "1");
            }	

        }

    }

    function sendFriendRequest(domid, uid) {
        
        var spinner = document.querySelector('#spb_'+domid+' .send_req .spinner');
        var icon = document.querySelector('#spb_'+domid+' .send_req i');
        spinner.style.display = "block";
        icon.style.display = "none";

        var xml = new XMLHttpRequest();

        xml.onreadystatechange = function() {
            if(this.status==200 && this.readyState==4) {
                var resp = this.responseText;
                setTimeout(function(){
                    spinner.style.display = "none";
                    if(resp==3) {
                        alertmain("You cannot send friend request to yourself.");
                        icon.style.display = "block";
                    }
                    else if(resp==2) {
                        alertmain("You have already sent a friend request to this user.");
                        icon.style.display = "block";
                    }
                    else if(resp==1) {
                        document.querySelector('#spb_'+domid+' .send_req #friend_req_sent').style.display = "block";
                    }
                    else {
                        console.log(resp);
                    }

                },50);
            }
        }
        var formdata = new FormData();
        formdata.append("frienduid", uid);
        xml.open("POST", "./api/friendRequests/sendRequest");
        xml.withCredentials = true;
        xml.send(formdata);

    }

    function followpage(which, id) {
        document.querySelector('#spageb_'+id+' .followicon .main').style.display = "none";
        document.querySelector('#spageb_'+id+' .followicon .spinner').style.display = "block";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    if(resp==1) {
                        document.querySelector('#spageb_'+id+' .followicon .spinner').style.display = "none";
                        document.querySelector('#spageb_'+id+' .followicon .main').style.display = "flex";
                        document.querySelector('#spageb_'+id+' .followicon .main i').style.color = "var(--hover-color)";
                        document.querySelector('#spageb_'+id+' .followicon .main i').style.fontWeight = "bold";
                        document.querySelector('#spageb_'+id+' .followicon .main i').setAttribute('onclick', 'unfollowpage('+'"'+which+'"'+', '+'"'+id+'"'+')');
                        var count = parseInt(document.querySelector('#spageb_'+id+' .followicon .main .followcount').innerHTML)+1;
                        document.querySelector('#spageb_'+id+' .followicon .main .followcount').innerHTML = count;
                    }
                    else if(resp==0){
                        document.querySelector('#spageb_'+id+' .followicon .spinner').style.display = "none";
                        document.querySelector('#spageb_'+id+' .followicon .main').style.display = "flex";
                        alertmain("Server Error! Please try again later.");
                    }
                    else {
                        alertmain(resp);
                    }
                }, 40);
            }
        }
        var formdata = new FormData();
        formdata.append("pid", which);
        formdata.append('statechangetype', 'follow');
        xml.open("POST", "./api/pageOperations/follow-state-change");
        xml.withCredentials = true;
        xml.send(formdata);
    }

    function unfollowpage(which, id) {
        document.querySelector('#spageb_'+id+' .followicon .main').style.display = "none";
        document.querySelector('#spageb_'+id+' .followicon .spinner').style.display = "block";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    if(resp==1) {
                        document.querySelector('#spageb_'+id+' .followicon .spinner').style.display = "none";
                        document.querySelector('#spageb_'+id+' .followicon .main').style.display = "flex";
                        document.querySelector('#spageb_'+id+' .followicon .main i').style.color = "#333";
                        var count = parseInt(document.querySelector('#spageb_'+id+' .followicon .main .followcount').innerHTML)-1;
                        document.querySelector('#spageb_'+id+' .followicon .main .followcount').innerHTML = count;
                        document.querySelector('#spageb_'+id+' .followicon .main i').setAttribute('onclick', 'followpage('+'"'+which+'"'+', '+'"'+id+'"'+')');
                    }
                    else if(resp==0) {
                        document.querySelector('#spageb_'+id+' .followicon .spinner').style.display = "none";
                        document.querySelector('#spageb_'+id+' .followicon .main').style.display = "flex";
                        alertmain("Server Error! Please try again later.");
                    }
                    else {
                        alertmain(resp);
                    }
                }, 40);
            }
        }
        var formdata = new FormData();
        formdata.append("pid", which);
        formdata.append('statechangetype', 'unfollow');
        xml.open("POST", "./api/pageOperations/follow-state-change");
        xml.withCredentials = true;
        xml.send(formdata);
    }


    /* --------------- */ 
    function load_noti(offset, limit, total, dom) {
        try {
            dom.style.display = "none";
        }
        catch(err) {
            
        }
        document.querySelector('.noti_dropdown .mcont .bottom .spinner').style.display = "block";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange= function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                setTimeout(function(){
                    document.querySelector('.noti_dropdown .mcont .bottom .spinner').style.display = "none";
                    document.querySelector('.noti_dropdown .mcont .bottom .noti_main').innerHTML += resp;
                }, 250);
            }
        }
        xml.open("POST", "../../src/load/notifications");
        xml.withCredentials = true;
        var formdata = new FormData();
        formdata.append("which", "getnoti");
        if(offset==undefined) {
            offset = 0;
        }

        if(limit==undefined) {
            limit = 8;
        }

        if(total==undefined) {
            total = 'null';
        }

        formdata.append('offset', offset);
        formdata.append('total', total);
        formdata.append('limit', limit);
        xml.send(formdata);
    }

    function loadlazyposts(id) {

        var f_data = undefined;
        var s_data = undefined;
        var t_data = undefined;
        var shown = undefined;
        var not = undefined;

        try {
             f_data = document.querySelector('.loadmore').getAttribute('data-fdata');
             s_data = document.querySelector('.loadmore').getAttribute('data-sdata');
             t_data = document.querySelector('.loadmore').getAttribute('data-tdata');
             shown = document.querySelector('.loadmore').getAttribute('data-shown');
             not = document.querySelector('.loadmore').getAttribute('data-not');

        }
        catch(err) {
             
        }

        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200) {
                var resp = this.responseText;
                document.querySelector('.postloader').style.display = "none";
                try {
                    document.querySelector(id).style.display = "none";
                }
                catch(err) {
                }


                if(resp==0) {
                    document.querySelector('#feed').innerHTML += "<center><span style='color: gray;font-size: 13px;'>Follow more pages to add more memes or wait for some more time.</span></center><br><br>";					
                }
                else {
                    document.querySelector('#feed').innerHTML += resp;
                }

            }
        }
        xml.open("POST", "/api/loadPosts");
        xml.withCredentials = true;
        var formdata = new FormData();
        formdata.append('px', window.innerWidth+"x"+window.innerHeight);
        
        if(f_data==undefined || f_data==0) {
            f_data = {limit:8, offset:0, datebefore:2, do:1};
            formdata.append('f_data', JSON.stringify(f_data));
        }
        else {
            formdata.append('f_data', f_data);
        }	

        if(s_data==undefined || s_data==0) {
            s_data = {limit:8, offset:0, datebefore:9, do:1};
            formdata.append('s_data', JSON.stringify(s_data));
        }
        else {
            formdata.append('s_data', s_data);	
        }

        if(t_data==undefined || t_data==0) {
            t_data = {limit:8, offset:0, datebefore:9};
            formdata.append('t_data', JSON.stringify(t_data));
        }
        else {
            formdata.append('t_data', t_data);	
        }

        if(shown==undefined || shown==0) {
            shown = [];
            formdata.append('shown', JSON.stringify(shown));
        }
        else {
            formdata.append('shown', shown);
        }

        if(not==undefined || not==0) {
            not = [];
            formdata.append('not', JSON.stringify(not));
        }
        else {
            formdata.append('not', not);
        }

        xml.send(formdata);
    }