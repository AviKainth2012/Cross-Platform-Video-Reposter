const loginForm = document.getElementById("loginForm");
const statusDiv = document.getElementById("status");

loginForm.addEventListener("submit", async e => {
    e.preventDefault();
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const res = await fetch("api/login.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:`email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    });
    const text = await res.text();
    if(text==="success"){
        statusDiv.textContent="Login successful! Redirecting...";
        setTimeout(()=>{window.location.href="index.html";},1000);
    }else statusDiv.textContent="Invalid email or password!";
});
