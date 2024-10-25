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


CREATE TABLE subscriptions(
    id int AUTO_INCREMENT,
    user_id int, -- user_id subscribes to subscription
    subscription int, -- references a user's id
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (subscription) REFERENCES users(id)
);

CREATE TABLE clips (
    id int AUTO_INCREMENT,
    owner int, -- user's id
    name varchar(255),
    time datetime,
    tags int,
    extension varchar(16),
    PRIMARY KEY (id),
    FOREIGN KEY (owner) REFERENCES users(id),
    FOREIGN KEY (tags) REFERENCES tags(id)
);

CREATE TABLE liked_clips(
    id int AUTO_INCREMENT,
    user_id int,
    clip_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (clip_id) REFERENCES clips(id)
);

CREATE TABLE disliked_clips(
    id int AUTO_INCREMENT,
    user_id int,
    clip_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (clip_id) REFERENCES clips(id)
);

CREATE TABLE comments(
    id int AUTO_INCREMENT,
    author int,
    parent int,
    FOREIGN KEY (author) REFERENCES users(id),
    FOREIGN KEY (parent) REFERENCES comments(id),
    PRIMARY KEY (id)
);

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