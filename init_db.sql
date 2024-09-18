DROP DATABASE IF EXISTS waves;
use waves;

CREATE TABLE users (
    username,
    password,
    subscriptions,
    liked,
    description,
);

CREATE TABLE clips (
    id,
    views,
    likes,
    dislikes,
    tags,
);

CREATE TABLE tags(
    id,
    tag,
);

