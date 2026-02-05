-- -- Create database
-- CREATE DATABASE IF NOT EXISTS video_app;
-- USE video_app;

-- -- =========================
-- -- USERS TABLE
-- -- =========================
-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     name VARCHAR(255) NOT NULL,
--     email VARCHAR(255) UNIQUE NOT NULL,
--     password VARCHAR(255) NOT NULL,

--     channelName VARCHAR(255),
--     channelDescription TEXT,

--     totalSubscriber INT DEFAULT 0,

--     -- JSON / TEXT array of users who subscribed
--     subscribers TEXT,

--     joinedOn DATETIME DEFAULT CURRENT_TIMESTAMP
-- );

-- -- =========================
-- -- VIDEOS TABLE
-- -- =========================
-- CREATE TABLE videos (
--     id INT AUTO_INCREMENT PRIMARY KEY,

--     title VARCHAR(255) NOT NULL,
--     description TEXT,
--     videoUrl VARCHAR(500) NOT NULL,

--     tags TEXT,
--     category VARCHAR(100),

--     totalLikes INT DEFAULT 0,
--     likesArray TEXT,

--     totalDislike INT DEFAULT 0,
--     dislikeArray TEXT,

--     totalViews INT DEFAULT 0,

--     uploadedBy INT NOT NULL,

--     createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
-- );

-- -- =========================
-- -- SAMPLE USER
-- -- =========================
-- INSERT INTO users 
-- (name, email, password, channelName, channelDescription, subscribers)
-- VALUES
-- (
--  'Admin User',
--  'admin@gmail.com',
--  'admin123',
--  'Admin Channel',
--  'This is my first channel',
--  '[]'
-- );

-- -- =========================
-- -- SAMPLE VIDEO
-- -- =========================
-- INSERT INTO videos
-- (title, description, videoUrl, tags, category, uploadedBy, likesArray, dislikeArray)
-- VALUES
-- (
--  'First Video',
--  'This is demo video',
--  'https://example.com/video.mp4',
--  'tech,education',
--  'Education',
--  1,
--  '[]',
--  '[]'
-- );



-- =========================
-- CREATE DATABASE
-- =========================
CREATE DATABASE IF NOT EXISTS video_app;
USE video_app;

-- =========================
-- USERS TABLE
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,

    channelName VARCHAR(255),
    channelDescription TEXT,

    totalSubscriber INT DEFAULT 0,

    -- Array of FULL USER DATA who subscribed
    -- Example:
    -- [
    --  { "id":2, "name":"Aman", "email":"aman@gmail.com", "channelName":"Aman Tech" }
    -- ]
    subscribers TEXT,

    joinedOn DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- VIDEOS TABLE
-- =========================
CREATE TABLE videos (
    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,
    description TEXT,
    videoUrl VARCHAR(500) NOT NULL,

    tags TEXT,
    category VARCHAR(100),

    totalLikes INT DEFAULT 0,

    -- Array of FULL USER DATA who liked
    likesArray TEXT,

    totalDislike INT DEFAULT 0,

    -- Array of FULL USER DATA who disliked
    dislikeArray TEXT,

    totalViews INT DEFAULT 0,

    -- FULL USER DATA who uploaded video
    -- Example:
    -- {
    --   "id":1,
    --   "name":"Admin User",
    --   "email":"admin@gmail.com",
    --   "channelName":"Admin Channel",
    --   "channelDescription":"This is my first channel"
    -- }
    uploadedBy TEXT,

    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- SAMPLE USER
-- =========================
INSERT INTO users
(name, email, password, channelName, channelDescription, subscribers)
VALUES
(
 'Admin User',
 'admin@gmail.com',
 'admin123',
 'Admin Channel',
 'This is my first channel',
 '[]'
);

-- =========================
-- SAMPLE VIDEO
-- =========================
INSERT INTO videos
(
 title,
 description,
 videoUrl,
 tags,
 category,
 uploadedBy,
 likesArray,
 dislikeArray
)
VALUES
(
 'First Video',
 'This is demo video',
 'https://example.com/video.mp4',
 'tech,education',
 'Education',
 '{
   "id":1,
   "name":"Admin User",
   "email":"admin@gmail.com",
   "channelName":"Admin Channel",
   "channelDescription":"This is my first channel"
 }',
 '[]',
 '[]'
);
