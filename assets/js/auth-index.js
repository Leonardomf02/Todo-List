// Login
document.getElementById("login-btn").addEventListener("click", function(event){
    event.preventDefault();
    var loginEmail = document.getElementById("login_email").value;
    var loginPassword = document.getElementById("login_password").value;

    fetch("http://localhost:80/finalv2/controllers/authController.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'login': '',
            'login_email': loginEmail,
            'login_password': loginPassword
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if(data.status === "success") {
            if(data.usertype === "admin") {
                window.location.href = `views/homeadmin.php?username=${data.username}`;
            } else {
                window.location.href = `/finalv2/views/home.php?username=${data.username}`;
            }
        } else {
            alert(data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});
