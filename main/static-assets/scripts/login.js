
function customAlert(cont) {
    document.querySelector('.alert_main .info_content span').innerHTML = cont;
    document.querySelector('.alert_main').style.display = "block";
    setTimeout(function(){
        document.querySelector('.alert_main').style.display = "none";
    }, 4200);
}

function ageCheck(date, month, year) {
    var obj = new Date();

    if(date==0 || month==0 || year==0) {
        return 0;
    }
    else {

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

}

function usrncheck() {

    var val = document.querySelector('.username input').value;
    document.querySelector('#usrncheck').style.display = "none";
    document.querySelector('#usrnavl').style.display = "none";
    document.querySelector('#usrnnavl').style.display = "none";

    document.querySelector("#signup_btn").setAttribute("disabled", "true");
    document.querySelector("#signup_btn").style.cursor = "auto";

    if(val.length>=7 && val.length<=18) {
        
        document.querySelector('#usrncheck').style.display = "block";
        var xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if(this.readyState==4 && this.status==200) {
                var resp = this.responseText;
                if(resp=='1') {
                    document.querySelector('#usrncheck').style.display = "none";
                    document.querySelector('#usrnnavl').style.display = "none";
                    document.querySelector('#usrnavl').style.display = "block";
                    document.querySelector("#signup_btn").removeAttribute("disabled");
                    document.querySelector("#signup_btn").style.cursor = "pointer";
                }
                else if(resp=='0') {
                    document.querySelector('#usrnavl').style.display = "none";
                    document.querySelector('#usrncheck').style.display = "none";
                    document.querySelector('#usrnnavl').style.display = "block";
                    document.querySelector("#signup_btn").setAttribute("disabled", "true");
                    document.querySelector("#signup_btn").style.cursor = "auto";
                }
                else {
                    document.querySelector('#usrnavl').style.display = "none";
                    document.querySelector('#usrncheck').style.display = "none";
                    document.querySelector('#usrnnavl').style.display = "block";
                    document.querySelector("#signup_btn").setAttribute("disabled", "true");
                    document.querySelector("#signup_btn").style.cursor = "auto";
                    customAlert(resp);
                    console.log(resp);
                }
            }
        }
        xml.open("POST", "src/usrncheck");
        var formdata = new FormData();
        formdata.append("value", val);
        xml.send(formdata);

    }
    else {
        document.querySelector('#usrnavl').style.display = "none";
                    document.querySelector('#usrncheck').style.display = "none";
                    document.querySelector('#usrnnavl').style.display = "block";
                    document.querySelector("#signup_btn").setAttribute("disabled", "true");
                    document.querySelector("#signup_btn").style.cursor = "auto";
    }


}

function scrollfbio() {
    var elem = document.querySelector('.signup');
    elem.scroll({
        top: 350,
        left: 0,
        behavior: 'smooth'
    });
}

function scrollup_signup() {
    var currScrollOffset = $(".signup").scrollTop();		
    var main = parseInt(currScrollOffset)-95;
    document.querySelector('.signup').scroll({
        top: main,
        left: 0,
        behavior: 'smooth'
    });		
    document.querySelector('.scroll_down').style.visibility = "visible";
}

function scrolldown_signup() {
    var currScrollOffset = $(".signup").scrollTop()+95;
    document.querySelector('.signup').scroll({
        top: currScrollOffset,
        behavior: 'smooth'
    });
}

function focusInput(inputType) {
    if (inputType === "usr") {
        document.querySelector(".usrdiv .highlighter").style.background = "var(--hover-color)";
        document.querySelector(".usrdiv .highlighter i").style.color = "white";
        var usrHeight = parseInt(window.getComputedStyle(document.querySelector(".iusr")).height) + 2.5;
        document.querySelector(".usrdiv .highlighter").style.height = usrHeight.toString() + "px";
    } else {
        document.querySelector(".passdiv .highlighter").style.background = "var(--hover-color)";
        document.querySelector(".passdiv .highlighter i").style.color = "white";
        var passHeight = parseInt(window.getComputedStyle(document.querySelector(".ipass")).height) + 2.5;
        document.querySelector(".passdiv .highlighter").style.height = passHeight.toString() + "px";
    }
    document.querySelector(".right .top").style.borderBottom = "2px solid var(--hover-color)";
}

function removeFocusInput(inputType) {
    if (inputType === "usr") {
        document.querySelector(".usrdiv .highlighter").style.background = "transparent";
        document.querySelector(".usrdiv .highlighter i").style.color = "white";
        var usrHeight = parseInt(window.getComputedStyle(document.querySelector(".iusr")).height) + 1;
        document.querySelector(".usrdiv .highlighter").style.height = usrHeight.toString() + "px";
    } else {
        document.querySelector(".passdiv .highlighter").style.background = "transparent";
        document.querySelector(".passdiv .highlighter i").style.color = "white";
        var passHeight = parseInt(window.getComputedStyle(document.querySelector(".ipass")).height) + 1;
        document.querySelector(".passdiv .highlighter").style.height = passHeight.toString() + "px";
    }
    document.querySelector(".right .top").style.borderBottom = "1px solid white";
}

function openSignup() {
    document.querySelector(".top").setAttribute("class", "top slider");
    setTimeout(function() {
        document.querySelector(".top").setAttribute("class", "top");
    }, 1005);
    $(".signup").animate({
        position: "absolute",
        left: "50%"
    });
    $(".login").animate({
        position: "absolute",
        left: "-500px"
    });
    document.querySelector(".signup").style.transform = "translate(-50%, 0)";
    $(".right").animate({
        height: "450px"
    }, "medium");
    document.querySelector(".top span font").innerHTML = "Login";
    document.querySelector(".top span").setAttribute("onclick", "openSignin()");
    document.querySelector(".top h1").innerHTML = "SIGN UP";
}

function openSignin() {
    document.querySelector(".top h1").innerHTML = "SIGN IN";
    document.querySelector(".top").setAttribute("class", "top slider");
    setTimeout(function() {
        document.querySelector(".top").setAttribute("class", "top");
    }, 1005);
    $(".login").animate({
        position: "absolute",
        left: "50%"
    });
    $(".signup").animate({
        position: "absolute",
        left: "-500px"
    });
    document.querySelector(".login").style.transform = "translate(-50%, 0)";
    $(".right").animate({
        height: "370px"
    }, "medium");
    document.querySelector(".top span font").innerHTML = "Signup";
    document.querySelector(".top span").setAttribute("onclick", "openSignup()");
}

function signupInputFocus(inputType) {
    try {
        document.querySelector("." + inputType + " .highlighter").style.background = "var(--hover-color)";
        document.querySelector(".right .top").style.borderBottom = "2px solid var(--hover-color)";
    } catch (error) {
        console.log(error);
    }

    if (["email", "password"].includes(inputType)) {
        var signupElement = document.querySelector(".signup");
        var scrollTop = $(".signup").scrollTop();
        var newScrollTop = parseInt(scrollTop) + 200;
        signupElement.scroll({
            top: newScrollTop,
            left: 0,
            behavior: "smooth"
        });
        document.querySelector(".signup .scroll").style.visibility = "visible";
    }
}

function picShow() {
    var file = document.querySelector(".pic input").files[0];
    if (file.size <= 6291456) {
        document.querySelector(".pic .spinner").style.display = "block";

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                var response = this.responseText;
                setTimeout(function() {
                    document.querySelector(".pic .spinner").style.display = "none";
                    if (response === "nai_er") {
                        customAlert("The File is not an Image.");
                    } else if (response === "isset_er") {
                        customAlert("Server Error! Please try again later.");
                    } else {
                        document.querySelector(".pic .upload").setAttribute("class", "upload apseudo");
                        document.querySelector(".pic .upload").style.border = "2px solid var(--main-border)";
                        document.querySelector(".pic .upload").style.backgroundImage = "url('data/temp_uploads/" + response + "')";
                        document.querySelector(".pic .upload").setAttribute("data", response);
                    }
                }, 800);
            }
        };

        var formData = new FormData();
        formData.append("file", file);
        xhr.open("POST", "src/temp/imageupload.temp");
        xhr.send(formData);
    } else {
        customAlert("The File is too Big. (Max-6MB)");
    }
}

function removeSignupInputFocus(inputType) {
    document.querySelector("." + inputType + " .highlighter").style.background = "rgba(0, 0, 0, 0.60)";
    document.querySelector(".right .top").style.borderBottom = "1px solid var(--main-border)";
}


function signupFormSubmit() {
    if (otpValidated === 1) {
        document.querySelector(".right .top .spinner").style.display = "block";
        
        var fullname = document.querySelector(".fullname input").value;
        var pic = document.querySelector(".pic .upload").getAttribute("data");
        var username = document.querySelector(".username input").value;
        var email = document.querySelector(".email input").value;
        var gender = document.querySelector("#genderval").getAttribute("value");
        var bio = document.querySelector(".bio textarea").value;
        var day = document.querySelector(".birthday select[name=day]").getAttribute("value");
        var month = document.querySelector(".birthday select[name=month]").getAttribute("value");
        var year = document.querySelector(".birthday select[name=year]").getAttribute("value");
        var password = document.querySelector(".password input").value;
        
        var tags = [];
        var checkboxes = document.querySelectorAll(".topics input[type=checkbox]:checked");
        var numCheckboxes = checkboxes.length;
        if (numCheckboxes > 0) {
            for (var i = 0; i < numCheckboxes; i++) {
                var value = checkboxes[i].value;
                tags.push(value);
            }
        }
        
        if (ageCheck(day, month, year)) {
            if (gender !== "0") {
                if (day === null || month === null || year === null) {
                    document.querySelector(".right .top .spinner").style.display = "none";
                    customAlert("Please select your birthday.");
                } else {
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = xhr.responseText;
                            console.log(response);
                            setTimeout(function() {
                                document.querySelector(".right .top .spinner").style.display = "none";
                                if (response === "1") {
                                    customAlert("Registration Successful! Login to continue.");
                                    setTimeout(function() {
                                        Location.reload();
                                    }, 1500);
                                } else {
                                    // customAlert(response);
                                }
                            }, 500);
                        }
                    };
                    
                    var formData = new FormData();
                    formData.append("fullname", fullname);
                    formData.append("pic", pic);
                    formData.append("username", username);
                    formData.append("email", email);
                    formData.append("gender", gender);
                    formData.append("bio", bio);
                    formData.append("day", day);
                    formData.append("month", month);
                    formData.append("year", year);
                    formData.append("password", password);
                    formData.append("tags", JSON.stringify(tags));
                    
                    xhr.open("POST", "./api/userAuth/signup");
                    xhr.send(formData);
                }
            } else {
                document.querySelector(".right .top .spinner").style.display = "none";
                customAlert("Please select your gender.");
            }
        } else {
            document.querySelector(".right .top .spinner").style.display = "none";
            customAlert("You must be at least 10 years old to register on IMemes.");
        }
    }
}

function signinFormSubmit() {
    document.querySelector(".right .top .spinner").style.display = "block";
    var loginCred = document.querySelector("#login_cred").value;
    var loginPass = document.querySelector("#login_pass").value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            setTimeout(function() {
                document.querySelector(".right .top .spinner").style.display = "none";
                console.log(response);
                if (response === "1") {
                    window.location = "./api/user/inituser";
                } else {
                    customAlert("Couldn't sign in! Wrong email or password.");
                }
            }, 1050);
        }
    };

    var formData = new FormData();
    formData.append("login_cred", loginCred);
    formData.append("login_pass", loginPass);

    xhr.open("POST", "./api/userAuth/signin");
    xhr.send(formData);
    return false;
}

function sendOtp() {
    var email = document.querySelector(".email input").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response === "0") {
                customAlert("Please enter a valid email.");
            } else {
                document.querySelector(".overlayChkEmail").style.display = "flex";
                document.querySelector(".overlayChkEmail input").setAttribute("data", btoa(response));
            }
        }
    };
    xhr.open("POST", "./api/generate-otp");
    var formData = new FormData();
    formData.append("email", email);
    xhr.send(formData);
}

function validateOtp() {
    var encodedData = document.querySelector(".overlayChkEmail input").getAttribute("data");
    var enteredOtp = document.querySelector(".overlayChkEmail input").value.toString();
    
    if (atob(encodedData) === enteredOtp) {
        document.querySelector(".overlayChkEmail").style.display = "none";
        otpValidated = 1;
        customAlert("It usually takes 10-15 seconds to get registered.");
        signupFormSubmit();
    } else {
        customAlert("Wrong OTP entered.");
        setTimeout(function() {
            location.reload();
        }, 2500);
    }
}