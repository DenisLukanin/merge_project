document.querySelector(".error-auth").style.visibility = "hidden";

document.querySelector(".auth").addEventListener("click", function(e) {
    if(!e.target.hasAttribute("auth__button")){
        return;
    }

    let login = document.getElementById("login").value;
    let password = document.getElementById("password").value;

    let user = {
        login: login,
        password: password
    }

    fetch("/user/rest/user/auth/", {
        method: 'POST',
        header: {
            'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(user)
    }).then(response => response.json()).then(function(data) {
        if(data["success"] == "true") {
            location = "http://merge/" + data["redirect_url"];
        }
        else {
            document.querySelector(".error-auth").style.visibility = "visible";
        }
    })
})