// Signup
document.getElementById("signup-btn").addEventListener("click", function(event){
    event.preventDefault();
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var cPassword = document.getElementById("c_password").value;
    var city = document.getElementById("city").value;

    fetch("../controllers/authController.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'signup': '', // Alterado para 'signup'
            'username': username,
            'email': email,
            'password': password,
            'c_password': cPassword,
            'signup_city': city // Alterado para 'signup_city'
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if(data.status === "success") {
            window.location.href = '../index.php';
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});
