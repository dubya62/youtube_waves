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
    return isLikedById($conn, $user_id, $clip_id);
}

// function to get whether or not current user has disliked this clip
function isDislikedByCookie($conn, $clip_id){
    $user_id = getUserIdByCookie($conn);
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

// function to get number of people a person is subscribed to
function getSubscriptionCount($conn, $user_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM subscriptions WHERE user_id=?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    return $result;
}

// function to get the number of waves a person has submitted
function getWaveCount($conn, $user_id){
    $stmt = $conn->prepare("SELECT COUNT(owner) FROM clips WHERE owner=?");
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

function getFollowerCount($conn, $user_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM subscriptions WHERE subscription=?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    return $result;
}

// function to follow a certain user id
function followUser($conn, $user_id, $follow_user){
    if (!checkIfFollowingUser($conn, $user_id, $follow_user)){
        $stmt = $conn->prepare("INSERT INTO subscriptions (user_id, subscription) VALUES (?, ?)");
        $stmt->bind_param("ss", $user_id, $follow_user);
        $stmt->execute();
    }
}
// function to unfollow a certain user id
function unfollowUser($conn, $user_id, $follow_user){
    $stmt = $conn->prepare("DELETE FROM subscriptions WHERE user_id=? AND subscription=?");
    $stmt->bind_param("ss", $user_id, $follow_user);
    $stmt->execute();
}
// function to check if following a certain user
function checkIfFollowingUser($conn, $user_id, $follow_user){
    $stmt = $conn->prepare("SELECT COUNT(id) FROM subscriptions WHERE user_id=? AND subscription=?");
    $stmt->bind_param("ss", $user_id, $follow_user);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    return $result != 0;
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

// function to get clip that a comment id was left on
function getCommentClip($conn, $comment_id){
    $stmt = $conn->prepare("SELECT clip_id FROM comments WHERE id=?");

    $stmt->bind_param("s", $comment_id);

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

// function to get owner of a clip
function getClipOwner($conn, $clip_id){
    $stmt = $conn->prepare("SELECT owner FROM clips WHERE id=?");
    $stmt->bind_param("s", $clip_id);
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

// function to add a number to a user's sentiment towards a tag
function addUserSentimentToTag($conn, $user_id, $tag_id, $sentiment){
    # create an entry in the user_tags table if it does not exist
    $stmt = $conn->prepare("SELECT COUNT(id) FROM user_tags WHERE user_id=? AND tag_id=?");
    $stmt->bind_param("ss", $user_id, $tag_id);
    $stmt->execute();
    $stmt->bind_result($result1);
    $stmt->fetch();

    $result = $result1;

    $stmt->free_result();

    // if that tag did not exist, create it and set the sentiment to that value
    if ($result == 0){
        $stmt2 = $conn->prepare("INSERT INTO user_tags (user_id, tag_id, sentiment) VALUES (?, ?, ?)");
        $stmt2->bind_param("sss", $user_id, $tag_id, $sentiment);
        $stmt2->execute();

    } else { // otherwise, update that tag to add the value
        // get the current sentiment for that tag
        $stmt3 = $conn->prepare("SELECT sentiment FROM user_tags WHERE user_id=? AND tag_id=?");
        $stmt3->bind_param("ss", $user_id, $tag_id);
        $stmt3->execute();
        $stmt3->bind_result($previous_sentiment1);
        $stmt3->fetch();

        $previous_sentiment = $previous_sentiment1;
        $stmt3->free_result();

        $stmt4 = $conn->prepare("UPDATE user_tags SET sentiment=?+? WHERE user_id=? AND tag_id=?");
        $stmt4->bind_param("ssss", $sentiment, $previous_sentiment, $user_id, $tag_id);
        $stmt4->execute();

    }
}

// function to add a number to a user's sentiment towards a clip
function addUserSentimentToClip($conn, $user_id, $clip_id, $sentiment){
    // iterate through the tags on this clip and add the sentiment to each tag
    $stmt = $conn->prepare("SELECT tag_id FROM clip_tags WHERE clip_id=?");
    $stmt->bind_param("s", $clip_id);
    $stmt->execute();
    $stmt->bind_result($result);

    $res = [];
    while ($stmt->fetch()){
        $res[] = $result;
    }

    // $res now holds each tag_id
    foreach ($res as $tag_id){
        addUserSentimentToTag($conn, $user_id, $tag_id, $sentiment);
    }
    
}

// like a clip
function unlikeClip($conn, $clip_id){
    $stmt = $conn->prepare("DELETE FROM liked_clips WHERE clip_id=? AND user_id=?");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $clip_id, $user_id);

    $stmt->execute();


    addUserSentimentToClip($conn, $user_id, $clip_id, -1);

}

function likeClip($conn, $clip_id){

    $stmt = $conn->prepare("INSERT INTO liked_clips (user_id, clip_id) VALUES (?, ?)");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $user_id, $clip_id);

    $stmt->execute();

    addUserSentimentToClip($conn, $user_id, $clip_id, 1);

}


// dislike a clip
function undislikeClip($conn, $clip_id){
    $stmt = $conn->prepare("DELETE FROM disliked_clips WHERE clip_id=? AND user_id=?");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $clip_id, $user_id);

    $stmt->execute();

    addUserSentimentToClip($conn, $user_id, $clip_id, 1);
}

function dislikeClip($conn, $clip_id){

    $stmt = $conn->prepare("INSERT INTO disliked_clips (user_id, clip_id) VALUES (?, ?)");

    $user_id = getUserIdByCookie($conn);

    $stmt->bind_param("ss", $user_id, $clip_id);

    $stmt->execute();

    addUserSentimentToClip($conn, $user_id, $clip_id, -1);

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

// return csv string of tag names for clip
function getClipTagNames($conn, $clip_id){
    $stmt = $conn->prepare("SELECT t.tag FROM tags t, clip_tags ct, clips c WHERE c.id=? AND ct.clip_id=c.id AND ct.tag_id=t.id");
    $stmt->bind_param("s", $clip_id);
    $stmt->execute();

    $stmt->bind_result($result);

    $res = [];
    while ($stmt->fetch()){
        $res[] = $result;
    }

    return $res;
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
    $user_id = getUserIdByCookie($conn);

    // use the algorithm to pick clips
    $stmt = $conn->prepare("SELECT id FROM clips real_c ORDER BY (SELECT SUM(ut.sentiment) FROM user_tags ut, tags t, users u, clips c, clip_tags ct WHERE ut.tag_id=t.id AND t.id=ct.tag_id AND ct.clip_id=c.id AND u.id=ut.user_id AND c.id=real_c.id AND u.id=?) DESC LIMIT ? OFFSET ?");

    $stmt->bind_param("sss", $user_id, $batchSize, $currentClipNumber);

    $stmt->execute();

    $stmt->bind_result($result);

    $res = [];

    while ($stmt->fetch()){
        $res[] = $result;
    }

    return $res;
}

function getClipScore($conn, $clip_id, $user_id){
    $stmt = $conn->prepare("SELECT SUM(ut.sentiment) FROM user_tags ut, tags t, users u, clips c, clip_tags ct WHERE ut.tag_id=t.id AND t.id=ct.tag_id AND ct.clip_id=c.id AND u.id=ut.user_id AND c.id=? AND u.id=?");

    $stmt->bind_param("ss", $clip_id, $user_id);

    $stmt->execute();

    $stmt->bind_result($result);

    return $result;
}

function deleteUser($conn, $user_id){
    try{
        $conn->begin_transaction();

        // Delete user comments
        $stmt = $conn->prepare("DELETE FROM comments WHERE author=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete subscriptions the user has
        $stmt = $conn->prepare("DELETE FROM subscriptions WHERE user_id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete records of clips the user has watched
        $stmt = $conn->prepare("DELETE FROM watched_clips WHERE user_id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete records of clips the user has liked
        $stmt = $conn->prepare("DELETE FROM liked_clips WHERE user_id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete records of clips the user has disliked
        $stmt = $conn->prepare("DELETE FROM disliked_clips WHERE user_id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete tags created by the user
        $stmt = $conn->prepare("DELETE FROM user_tags WHERE user_id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete tags associated with clips owned by the user
        $stmt = $conn->prepare("DELETE FROM clip_tags WHERE clip_id IN (SELECT id FROM clips WHERE owner=?)");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Delete all clips owned by the user
        $stmt = $conn->prepare("DELETE FROM clips WHERE owner=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        // Finally, delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

    } catch(Exception $e){
        echo "This didn't work: " . $e->getMessage();
        $conn->rollback();
    }
}

?>
