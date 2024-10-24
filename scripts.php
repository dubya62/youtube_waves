<?php
# The purpose of this file is to provide functions for other
# pages to include and execute

# functions will include database functionality
# and the algorithm

################################################
# Database Functions

# Connect to local database and return db instance
function initDb() {
    $db = new mysqli("localhost", "root", "databasePassword$", "waves");

    return $db;
}

# function to close a database connection
function closeDb($db) {
    mysqli_close($db) or die("Failed to close database connection!");
}


# function to check if a user is in the database
function check_user($conn, $username) {
    # prepare query
    $stmt = $conn->prepare("SELECT username FROM users WHERE username=?");

    # bind params
    $stmt->bind_param("s", $username);

    # execute statement
    $stmt->execute();

    $result = "";

    $stmt->bind_result($result);

    $rows = 0;
    while ($stmt->fetch()){
        $rows++;
    }

    $stmt->close();

    if ($rows > 0){
        return 1;
    }
    return 0;

}

# function to create a new user
function create_user($conn, $username, $password, $description) {
    # check if user already exists
    $exists = check_user($conn, $username);
    if ($exists){
        echo "User already exists!";
        return 0;
    }

    # prepare query
    $stmt = $conn->prepare("INSERT INTO users (username, password, description) VALUES (?, ?, ?)");

    # bind params
    $stmt->bind_param("sss", $username, hash('sha256', $password), $description);

    # execute statement
    $result = $stmt->execute();
    echo "New User Created!";

    $stmt->close();
    return 1;

}

# function to check whether or not a user provided the correct credentials
function authenticate_user($conn, $username, $password){
    # prepare query
    $stmt = $conn->prepare("SELECT username FROM users WHERE username=? AND password=?");

    # bind params
    $stmt->bind_param("ss", $username, hash('sha256', $password));

    # execute statement
    $stmt->execute();

    $result = "";

    # bind results
    $stmt->bind_result($result);
    $rows = 0;

    while ($stmt->fetch()){
        $rows++;
    }

    if ($rows > 0){
        return 1;
    }
    return 0;
}


# function to generate cookies
function get_cookie_val($conn, $username, $password) {
    # prepare query
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=? AND password=?");

    # bind params
    $stmt->bind_param("ss", $username, hash('sha256', $password));

    # execute statement
    $stmt->execute();

    $result = "";

    # bind results
    $stmt->bind_result($result);

    while ($stmt->fetch()){
        return $result;
    }

    return "DefaultCookie";
}


function logout(){
    setcookie("session", '', -1, '/');
    return true;
}


////////////////////////////////////////////////
// Backend Database Connection functionality

// function to get user's id by their cookie value
// returns -1 when the user is not authenticated
function getUserIdByCookie($conn) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE password=?");

    if (!isset($_COOKIE['session'])){
        return -1;
    }

    $stmt->bind_param("s", $_COOKIE['session']);

    $stmt->execute();
    $result = -1;

    $stmt->bind_result($result);

    $stmt->fetch();
    return $result;
}


// function to get whether or not a user has liked a clip
function isLikedById($conn, $user_id, $clip_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM liked_clips WHERE user_id=? AND clip_id=?");

    $stmt->bind_param("ss", $user_id, $clip_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    if ($result > 0){
        return 1;
    }
    return 0;
}

// function to get whether or not a user has disliked a clip
function isDislikedById($conn, $user_id, $clip_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM disliked_clips WHERE user_id=? AND clip_id=?");

    $stmt->bind_param("ss", $user_id, $clip_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    if ($result > 0){
        return 1;
    }
    return 0;
}

// function to get whether or not current user has liked this clip
function isLikedByCookie($conn, $clip_id){
    $user_id = getUserIdByCookie($conn);
    echo "user_id: " . $user_id;
    return isLikedById($conn, $user_id, $clip_id);
}

// function to get whether or not current user has disliked this clip
function isDislikedByCookie($conn, $clip_id){
    $user_id = getUserIdByCookie($conn);
    echo "user_id: " . $user_id;
    return isDislikedById($conn, $user_id, $clip_id);
}


// function to get number of subscribers by user id
function getSubscriberCount($conn, $user_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM subscriptions WHERE subscription=?");

    $stmt->bind_param("s", $user_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();
    
    return $result;
}

// function to return a list of users that the current user is following
function getFollowing($conn){
    $stmt = $conn->prepare("SELECT user_id FROM subscriptions WHERE user_id=?");

    // get the current user's id
    $user_id = getUserIdByCookie($conn);

    if ($user_id == -1){
        return [];
    }

    $stmt->bind_param("s", $user_id);

    $stmt->execute();

    $res = [];

    $stmt->bind_result($result);

    while ($stmt->fetch()){
        $res[] = $result;
    }


    return $res;
}

// function to get clips posted by a certain user
function getClipsByUserId($conn, $user_id){
    $stmt = $conn->prepare("SELECT id FROM clips WHERE owner=?");

    $stmt->bind_param("s", $user_id);

    $stmt->execute();

    $res = [];

    $stmt->bind_result($result);

    while ($stmt->fetch()){
        $res[] = $result;
    }

    return $res;
}

// function to get clips posted by the current user
function getClipsByCookie($conn){
    $user_id = getUserIdByCookie($conn);

    if ($user_id == -1){
        return [];
    }

    return getClipsByUserId($conn, $user_id);

}

// function to get the name of a clip by its id
function getClipName($conn, $clip_id){
    $stmt = $conn->prepare("SELECT name FROM clips WHERE id=?");

    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    return $result;
}

// function to get the number of likes on a clip
function getClipLikes($conn, $clip_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM liked_clips WHERE clip_id=?");

    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    return $result;

}

// function to get the number of dislikes on a clip
function getClipDislikes($conn, $clip_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM disliked_clips WHERE clip_id=?");

    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    return $result;
    

}

// function to get owner (user_id) of a comment
function getCommentOwner($conn, $comment_id){
    $stmt = $conn->prepare("SELECT author FROM comments WHERE id=?");

    $stmt->bind_param("s", $comment_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    return $result;
}

// function to get the username from user id
function getUsername($conn, $user_id){
    $stmt = $conn->prepare("SELECT username FROM users WHERE id=?");

    $stmt->bind_param("s", $user_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    return $result;
}

// like a clip
function unlikeClip($conn, $clip_id){
    $stmt = $conn->prepare("DELETE FROM liked_clips WHERE clip_id=? AND user_id=?");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $clip_id, $user_id);

    $stmt->execute();

}

function likeClip($conn, $clip_id){
    unlikeClip($conn, $clip_id);

    $stmt = $conn->prepare("INSERT INTO liked_clips (user_id, clip_id) VALUES (?, ?)");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $user_id, $clip_id);

    $stmt->execute();

}


// dislike a clip
function undislikeClip($conn, $clip_id){
    $stmt = $conn->prepare("DELETE FROM disliked_clips WHERE clip_id=? AND user_id=?");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $clip_id, $user_id);

    $stmt->execute();

}

function dislikeClip($conn, $clip_id){
    undislikeClip($conn, $clip_id);

    $stmt = $conn->prepare("INSERT INTO disliked_clips (user_id, clip_id) VALUES (?, ?)");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $user_id, $clip_id);

    $stmt->execute();

}

// create a tags entry (returns the tag_id)
function createTagEntry($conn, $tag_string){
    // only insert if the tag does not exist. otherwise, return the tag's id
    $tag_id = -1;
    $stmt1 = $conn->prepare("SELECT id FROM tags WHERE tag=?");
    $stmt1->bind_param("s", $tag_string);
    $stmt1->execute();
    $stmt1->bind_result($tag_id);
    $stmt1->fetch();
    if ($tag_id != -1){
        return $tag_id;
    }

    $stmt = $conn->prepare("INSERT INTO tags (tag) VALUES (?)");

    $stmt->bind_param("s", $tag_string);

    $stmt->execute();

    return mysqli_insert_id($conn);
}


// create the link between clips and their tags
function createClipTag($conn, $clip_id, $tag){
    $stmt = $conn->prepare("INSERT INTO clip_tags (clip_id, tag_id) VALUES (?, ?)");

    $stmt->bind_param("ss", $clip_id, $tag);

    $stmt->execute();
}


// create a clip entry (returns the clip_id)
function createClipEntry($conn, $name, $tags){
    // split the tags up at each #
    $tags_array = explode('#', $tags);
    if (count($tags_array) > 0){
        // ignore everything before the first tag
        $tags_array = array_slice($tags_array, 1);

        // create tag etnries for each tag
        $tag_ids = [];
        foreach ($tags_array as $tag){
            $tag_id = createTagEntry($conn, $tag);
            $tags_ids[] = $tag_id;
        }
    } else {
        $tag_id = -1;
    }

    // get the current user's id
    $user_id = getUserIdByCookie($conn);

    // prepare the statement to create the clip entry
    $stmt = $conn->prepare("INSERT INTO clips (owner, name, time) VALUES (?, ?, NOW())");

    $stmt->bind_param("ss", $user_id, $name);

    $stmt->execute();

    $clip_id = mysqli_insert_id($conn);

    // create a clip_tag for each tag created
    foreach ($tags_ids as $tag){
        createClipTag($conn, $clip_id, $tag);
    }

    return $clip_id;
}


// get a clip's extension
function getClipExtension($conn, $clip_id){
    $stmt = $conn->prepare("SELECT extension FROM clips WHERE id=?");

    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    return $result;
}

// set a clip extension to a value
function setClipExtension($conn, $clip_id, $extension){
    $stmt = $conn->prepare("UPDATE clips SET extension=? WHERE id=?");

    $stmt->bind_param("ss", $extension, $clip_id);

    $stmt->execute();

}

// get an image's extension
function getImageExtension($conn, $clip_id){
    $stmt = $conn->prepare("SELECT image_extension FROM clips WHERE id=?");

    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

    $stmt->bind_result($result);

    $stmt->fetch();

    return $result;
}

// set an image extension to a value
function setImageExtension($conn, $clip_id, $extension){
    $stmt = $conn->prepare("UPDATE clips SET image_extension=? WHERE id=?");

    $stmt->bind_param("ss", $extension, $clip_id);

    $stmt->execute();

}

// get a batch of clips using the algorithm
function getClipBatch($conn, $currentClipNumber, $batchSize){
    // TODO: use the algorithm instead of just selecting in order
    $stmt = $conn->prepare("SELECT id FROM clips LIMIT ? OFFSET ?");

    $stmt->bind_param("ss", $batchSize, $currentClipNumber);

    $stmt->execute();

    $stmt->bind_result($result);

    $res = [];

    while ($stmt->fetch()){
        $res[] = $result;
    }

    return $res;
}



?>
