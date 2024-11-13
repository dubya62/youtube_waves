DROP DATABASE IF EXISTS waves;
CREATE DATABASE waves;
use waves;

CREATE TABLE tags(
    id int AUTO_INCREMENT,
    tag varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE users (
    id int AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    password varchar(511) NOT NULL,
    description varchar(255),
    PRIMARY KEY (id)
);

-- This table keeps track of which tags users like
CREATE TABLE user_tags (
    id int AUTO_INCREMENT,
    user_id int,
    tag_id int,
    sentiment float,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id)
);


CREATE TABLE subscriptions(
    id int AUTO_INCREMENT,
    user_id int, -- user_id subscribes to subscription
    subscription int, -- references a user's id
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subscription) REFERENCES users(id)
);

CREATE TABLE clips (
    id int AUTO_INCREMENT,
    owner int, -- user's id
    name varchar(255),
    time datetime,
    extension varchar(16),
    image_extension varchar(16),
    PRIMARY KEY (id),
    FOREIGN KEY (owner) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE watched_clips (
    id int AUTO_INCREMENT,
    user_id int,
    clip_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (clip_id) REFERENCES clips(id) ON DELETE CASCADE
);

CREATE TABLE clip_tags (
    id int AUTO_INCREMENT,
    clip_id int,
    tag_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (clip_id) REFERENCES clips(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

CREATE TABLE liked_clips(
    id int AUTO_INCREMENT,
    user_id int,
    clip_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (clip_id) REFERENCES clips(id) ON DELETE CASCADE
);

CREATE TABLE disliked_clips(
    id int AUTO_INCREMENT,
    user_id int,
    clip_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (clip_id) REFERENCES clips(id) ON DELETE CASCADE
);

CREATE TABLE comments(
    id int AUTO_INCREMENT,
    author int,
    clip_id int,
    parent int,
    FOREIGN KEY (author) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (clip_id) REFERENCES clips(id) ON DELETE CASCADE,
    FOREIGN KEY (parent) REFERENCES comments(id) ON DELETE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE liked_comments(
    id int AUTO_INCREMENT,
    user_id int,
    comment_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE
);

CREATE TABLE disliked_comments(
    id int AUTO_INCREMENT,
    user_id int,
    comment_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE
);

/*
-- View to get all search results by filtering through clips
CREATE VIEW filtered_clips AS
SELECT c.id, c.name AS clip_title, c.time, u.username, u.description AS user_description, t.tag AS clip_tag
FROM clips c
JOIN users u ON c.owner = u.id
LEFT JOIN tags t ON c.tags = t.id;

-- Procedure attempt to filter clips by search term
DELIMITER $$

CREATE PROCEDURE FilterClips(IN searchTerm VARCHAR(255))
BEGIN
    SELECT c.id, c.name AS clip_title, c.time, u.username, u.description AS user_description, t.tag AS clip_tag
    FROM clips c
    JOIN users u ON c.owner = u.id
    LEFT JOIN tags t ON c.tags = t.id
    WHERE c.name LIKE CONCAT('%', searchTerm, '%')
       OR u.description LIKE CONCAT('%', searchTerm, '%')
       OR t.tag LIKE CONCAT('%', searchTerm, '%');
END$$

DELIMITER ;

-- Full Text Search Option
ALTER TABLE clips ADD FULLTEXT(clip_title);
ALTER TABLE users ADD FULLTEXT(description);
ALTER TABLE tags ADD FULLTEXT(tag);
SELECT c.id, c.name AS clip_title, u.description AS user_description, t.tag AS clip_tag
FROM clips c
JOIN users u ON c.owner = u.id
LEFT JOIN tags t ON c.tags = t.id
WHERE MATCH(c.name) AGAINST(?) 
   OR MATCH(u.description) AGAINST(?) 
   OR MATCH(t.tag) AGAINST(?);
*/
