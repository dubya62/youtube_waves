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
    $stmt = $conn->prepare("INSERT INTO users (username, password, description) VALUES (?, PASSWORD(?), ?)");

    # bind params
    $stmt->bind_param("sss", $username, $password, $description);

    # execute statement
    $result = $stmt->execute();
    echo "New User Created!";

    $stmt->close();
    return 1;

}

# function to check whether or not a user provided the correct credentials
function authenticate_user($conn, $username, $password){
    # prepare query
    $stmt = $conn->prepare("SELECT username FROM users WHERE username=? AND password=PASSWORD(?)");

    # bind params
    $stmt->bind_param("ss", $username, $password);

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
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=? AND password=PASSWORD(?)");

    # bind params
    $stmt->bind_param("ss", $username, $password);

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

// get list of likes from user by user id
function getLikesByUserId($conn, $user_id){
    // prepare statement to select every comment
    // by the user's id
    $stmt = $conn->prepare("SELECT * FROM liked_clips WHERE user_id=?");

    $stmt->bind_param("s", $user_id);
    
    $stmt->execute();

    $result = NULL;
    $stmt->bind_result($result);

    return mysqli_fetch_all($result);
}

// get list of likes from user by user's cookie
function getLikesByCookie($conn, $cookie){
    // first, figure out the user id of the cookie owner

    // next, getLikesByUserId
}

// get list of likes from current user
function getCurrentLikes(){
    $conn = initDb();
    // getLikesByCookie with the current cookie
    getLikesByCookie($conn, $_COOKIE["session"]);

    closeDb($conn);
}

// function to get number of likes on a clip
function getLikesByClipId($conn, $clip_id){
    $stmt = $conn->prepare("SELECT COUNT(user_id) FROM liked_clips WHERE clip_id=?");
    
    $stmt->bind_param("s", $clip_id);

    $stmt->execute();

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

// function to get whether or not current user has liked this clip
function isLikedByCookie($conn, $clip_id){
    $user_id = getUserIdByCookie($conn);
    echo "user_id: " . $user_id;
    return isLikedById($conn, $user_id, $clip_id);
}






?>
