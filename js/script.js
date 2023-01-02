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
