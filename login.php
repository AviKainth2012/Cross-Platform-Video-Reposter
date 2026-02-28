<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h1>Login</h1>
    <form id="loginForm">
        <input type="email" id="email" placeholder="Email" required><br><br>
        <input type="password" id="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Sign Up</a></p>
    <div id="status"></div>
</div>
<script>
const loginForm = document.getElementById("loginForm");
loginForm.addEventListener("submit", async e=>{
    e.preventDefault();
    const res = await fetch("api/login_user.php", {
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:`email=${encodeURIComponent(document.getElementById("email").value)}&password=${encodeURIComponent(document.getElementById("password").value)}`
    });
    const text = await res.text();
    if(text==="success"){ window.location.href="index.php"; }
    else document.getElementById("status").textContent="Invalid email/password";
});
</script>
</body>
</html>