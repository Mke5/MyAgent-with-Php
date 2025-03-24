// see password functionality while signing in or signing up

const passwordField = document.getElementById("password");
const toggleBtn = document.getElementById("see");

toggleBtn.addEventListener('click', () =>{
    if(passwordField.type == "password"){
        passwordField.type = "text";
        toggleBtn.style.color = "#b1b0b0";
    }else{
        passwordField.type = "password";
        toggleBtn.style.color = "black";
    }
})