function login_validate(){
    var usern = document.forms["login_form"]["userName"].value;
    var pass = document.forms["login_form"]["passWord"].value;

    if(usern == "" || usern == null){
        //alert("Empty");
        document.getElementById("userName").style.borderColor = "red";
        document.getElementById("userText").style.color = "red";
        var errorUser = document.getElementById("usernameError");
        errorUser.innerHTML = "Username Can not be Empty";
        errorUser.style.color = "red";
        errorUser.style.fontSize = "12px";
        return false;
    }

    else if(pass == "" || pass == null){
        //alert("Empty");
        document.getElementById("passWord").style.borderColor = "red";
        document.getElementById("PassText").style.color = "red";
        var errorPass = document.getElementById("passError");
        errorPass.innerHTML = "Password Can not be Empty";
        errorPass.style.color = "red";
        errorPass.style.fontSize = "12px";
        return false;
    }
}


function valodateReg(){
    var regUser = document.forms["reg_form"]["Userreg"].value;
    var regEmail = document.forms["reg_form"]["Useremail"].value;
    var regPass = document.forms["reg_form"]["Userpass"].value;
    var regcPass = document.forms["reg_form"]["Usercpass"].value;

    if(regUser == "" || regUser == null){
        document.getElementById("regUser").style.color = "red";
        document.getElementById("Userreg").style.borderColor = "red";
        var userError = document.getElementById("reguserError");
        userError.innerHTML = "Username Can not be empty";
        userError.style.fontSize = "12px";
        userError.style.color = "red";
        return false;
    }

    else if(regEmail == "" || regEmail == null){
        document.getElementById("regEmail").style.color = "red";
        document.getElementById("Useremail").style.borderColor = "red";
        var emailError = document.getElementById("regemailError");
        emailError.innerHTML = "Username Can not be empty";
        emailError.style.fontSize = "12px";
        emailError.style.color = "red";
        return false;
    }
}
