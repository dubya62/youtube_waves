DROP DATABASE IF EXISTS waves;
CREATE DATABASE waves;
use waves;

CREATE TABLE tags(
    id int,
    tag varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE liked_clips(
    id int,
    clip_id int,
    PRIMARY KEY (id)
);

CREATE TABLE subscriptions(
    id int,
    subscription varchar(255),
    PRIMARY KEY (id)
);

CREATE TABLE users (
    id int,
    username varchar(255) NOT NULL,
    password varchar(511) NOT NULL,
    description varchar(255),
    subscriptions int,
    liked int,
    FOREIGN KEY (subscriptions) REFERENCES subscriptions(id),
    FOREIGN KEY (liked) REFERENCES liked_clips(id),
    PRIMARY KEY (id)
);

CREATE TABLE clips (
    id int,
    views int,
    likes int,
    dislikes int,
    tags int,
    PRIMARY KEY (id),
    FOREIGN KEY (tags) REFERENCES tags(id)
);


CREATE TABLE comments(
    id int,
    author int,
    parent int,
    FOREIGN KEY (author) REFERENCES users(id),
    FOREIGN KEY (parent) REFERENCES comments(id),
    PRIMARY KEY (id)
);

