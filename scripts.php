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



################################################


?>
