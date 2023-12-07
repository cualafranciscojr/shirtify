function validateLoginForm() {
    var email = document.getElementById("typeEmailX").value;
    var password = document.getElementById("typePasswordX").value;
    var errorMessage = document.getElementById("loginErrorMessage");

    if (email === "" || password === "") {
        errorMessage.innerHTML = "Please fill in all fields";
        errorMessage.style.color = "red";

        setTimeout(function() {
            errorMessage.innerHTML = "";
        }, 3000);

        return false;
    }
    return true;
}


 // PHP Error message
 window.onload = function() {
    var errorMessage = document.getElementById("phpLoginErrorMessage");
    if (errorMessage) {
        setTimeout(function() {
            errorMessage.style.display = "none";
        }, 5000); // Set timeout for 5 seconds (5000 milliseconds)
    }
};