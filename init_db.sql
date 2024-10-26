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
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (tag_id) REFERENCES tags(id)
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
    extension varchar(16),
    image_extension varchar(16),
    PRIMARY KEY (id),
    FOREIGN KEY (owner) REFERENCES users(id)
);

CREATE TABLE watched_clips (
    id int AUTO_INCREMENT,
    user_id int,
    clip_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (clip_id) REFERENCES clips(id)
);

CREATE TABLE clip_tags (
    id int AUTO_INCREMENT,
    clip_id int,
    tag_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (clip_id) REFERENCES clips(id),
    FOREIGN KEY (tag_id) REFERENCES tags(id)
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

