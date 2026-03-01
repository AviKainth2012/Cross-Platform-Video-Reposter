1. First Create All Those Directories Make Sure /uploads is chmod 775 We Will Store Store API keys and DB credentials in environment variables.


/project-root
├── index.html          ← main upload page
├── login.html          ← login page
├── register.html       ← registration page
├── style.css           ← CSS
├── script.js           ← JS for index.html
├── login.js            ← JS for login page
├── config.php          ← database and environment config
├── /uploads            ← writable folder for uploaded videos
├── /api
│   ├── register.php
│   ├── login.php
│   ├── upload_video.php
│   ├── worker.php
│   ├── youtube_auth.php
│   ├── youtube_callback.php
│   ├── instagram_auth.php
│   ├── instagram_callback.php
│   ├── facebook_auth.php
│   ├── facebook_callback.php
│   ├── tiktok_auth.php
│   └── tiktok_callback.php

2. Then Run The MySQL Or MariaDB In The phpMyAdmin SQL Section Ensuring That your clikcing your right database

3. On IONOS: Set env variables in hosting panel. On Linux: Set them in /etc/environment or use .env and load with phpdotenv.
