const form = document.getElementById("registerForm");
const status = document.getElementById("status");

form.addEventListener("submit", async e => {
    e.preventDefault();
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const res = await fetch("api/register.php", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    });
    const text = await res.text();
    status.textContent = text==="success" ? "Registered successfully! Go to login." : "Error registering";
});
