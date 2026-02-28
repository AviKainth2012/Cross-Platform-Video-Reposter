// Logout button
document.getElementById("logoutBtn").addEventListener("click", async () => {
    await fetch("api/logout.php");
    window.location.href = "login.html";
});

// Upload form
const uploadForm = document.getElementById("uploadForm");
const uploadStatus = document.getElementById("uploadStatus");

uploadForm.addEventListener("submit", async e => {
    e.preventDefault();
    const formData = new FormData(uploadForm);
    const platforms = [];
    uploadForm.querySelectorAll("input[name='platforms[]']:checked").forEach(cb=>platforms.push(cb.value));
    formData.set("platforms", JSON.stringify(platforms));

    const res = await fetch("api/upload_video.php", { method: "POST", body: formData });
    const text = await res.text();
    uploadStatus.textContent = text;
    loadUploads(); // Refresh table
});

// Load user's uploads
async function loadUploads() {
    const res = await fetch("api/get_uploads.php");
    const data = await res.json();
    const tbody = document.querySelector("#uploadsTable tbody");
    tbody.innerHTML = "";
    data.forEach(item => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${item.video_path}</td>
            <td>${item.caption}</td>
            <td>${item.platform}</td>
            <td>${item.status}</td>
            <td>${item.error || ""}</td>
        `;
        tbody.appendChild(tr);
    });
}

// Initial load
loadUploads();
setInterval(loadUploads, 30000); // Refresh every 30 seconds