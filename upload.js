const uploadForm = document.getElementById("uploadForm");
const status = document.getElementById("status");

uploadForm.addEventListener("submit", async e=>{
    e.preventDefault();
    const formData = new FormData(uploadForm);
    const platforms = [];
    uploadForm.querySelectorAll("input[name='platforms[]']:checked").forEach(cb=>platforms.push(cb.value));
    formData.set("platforms", JSON.stringify(platforms));

    const res = await fetch("api/upload_video.php",{method:"POST",body:formData});
    const text = await res.text();
    status.textContent = text;
});
