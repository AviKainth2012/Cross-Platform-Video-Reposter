<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Multi-Platform Uploader</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Welcome to Multi-Platform Uploader</h1>
    <div class="nav">
        <button onclick="window.location.href='api/logout.php'">Logout</button>
        <a href="api/youtube_auth.php"><button class="youtube">Connect YouTube</button></a>
        <a href="api/instagram_auth.php"><button class="instagram">Connect Instagram</button></a>
        <a href="api/facebook_auth.php"><button class="facebook">Connect Facebook</button></a>
        <a href="api/tiktok_auth.php"><button class="tiktok">Connect TikTok</button></a>
    </div>
</header>

<main>
    <section class="upload-section">
        <h2>Upload Photo or Video</h2>
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="media" accept="video/*,image/*" required><br><br>
            <input type="text" name="caption" placeholder="Caption" required><br><br>
            Platforms:<br>
            <input type="checkbox" name="platforms[]" value="youtube"> YouTube
            <input type="checkbox" name="platforms[]" value="instagram"> Instagram
            <input type="checkbox" name="platforms[]" value="facebook"> Facebook
            <input type="checkbox" name="platforms[]" value="tiktok"> TikTok<br><br>
            <button type="submit">Upload</button>
        </form>
        <div id="uploadStatus"></div>
    </section>

    <section class="dashboard-section">
        <h2>My Uploads</h2>
        <table id="uploadsTable">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Caption</th>
                    <th>Platform</th>
                    <th>Status</th>
                    <th>Error</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </section>
</main>

<script src="dashboard.js"></script>
</body>
</html>