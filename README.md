# Cross-Platform-Video-Reposter
My Idea Is To Create A Functional Video Reposter To Help Users Post Videos To Multiple Platforms With A Click Of A Button Instead Of Manually doing it 

My First Idea Is To Create A Basic HTML File After Doing That

First Use PHPMYADMIN Go To SQL And Select Your DATABASE AND PASTE THIS IN 

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE connected_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    platform VARCHAR(50),
    access_token TEXT,
    refresh_token TEXT,
    expires_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    caption TEXT,
    video_path VARCHAR(255),
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE post_targets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    platform VARCHAR(50),
    status VARCHAR(50) DEFAULT 'pending',
    platform_post_id VARCHAR(255),
    error TEXT
);
