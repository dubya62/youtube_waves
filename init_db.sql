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
    owner int,
    name varchar(255),
    time date,
    tags int,
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

