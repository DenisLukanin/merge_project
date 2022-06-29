document.querySelector(".error-password").style.visibility = "hidden";
document.querySelector(".error-login").style.visibility = "hidden";

document.querySelector(".register").addEventListener("click", function(e) {
    if(!e.target.hasAttribute("register__button")){
        return
    }
    
    let password = document.getElementById("password").value;
    let password_confirm = document.getElementById("password_confirm").value;
    let login = document.getElementById("login").value;
    
    let user = {
        login: login,
        password: password,
    }

    if(password == password_confirm) {
        fetch("/user/rest/user/register/", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(user)
        }).then(response => response.json()
        ).then(
            function(data){
                if(data["success"] == "false") {
                    document.querySelector(".error-login").style.visibility = "visible"; 
                } else {
                    location = "http://merge/" + data["redirect_url"];
                }
            }
        )
    }
    else {
        document.querySelector(".error-password").style.visibility = "visible"; 
    }

    console.log(user);
})