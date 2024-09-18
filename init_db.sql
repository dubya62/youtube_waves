DROP DATABASE IF EXISTS waves;
use waves;

CREATE TABLE users (
    PRIMARY KEY (id),
    username varchar(255) NOT NULL,
    password varchar(511) NOT NULL,
    description varchar(255),
    FOREIGN KEY (subscriptions) REFERENCES users(username),
    FOREIGN KEY (liked) REFERENCES LIKED_CLIPS(id)
);

CREATE TABLE clips (
    PRIMARY KEY (id) NOT NULL,
    views,
    likes,
    dislikes,
    tags,
);

CREATE TABLE tags(
    id,
    tag,
);

