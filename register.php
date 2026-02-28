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
<title>Sign Up</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h1>Sign Up</h1>
    <form id="registerForm">
        <input type="email" id="email" placeholder="Email" required><br><br>
        <input type="password" id="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
    <div id="status"></div>
</div>
<script>
const registerForm = document.getElementById("registerForm");
registerForm.addEventListener("submit", async e=>{
    e.preventDefault();
    const res = await fetch("api/register_user.php", {
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:`email=${encodeURIComponent(document.getElementById("email").value)}&password=${encodeURIComponent(document.getElementById("password").value)}`
    });
    const text = await res.text();
    document.getElementById("status").textContent = text==="success" ? "Registered! Login now." : "Error registering";
});
</script>
</body>
</html>