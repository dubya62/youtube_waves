<?php
# The purpose of this file is to provide functions for other
# pages to include and execute

# functions will include database functionality
# and the algorithm

################################################
# Database Functions

# Connect to local database and return db instance
function initDb() {
    echo "before";
    $db = new mysqli("localhost", "root", getenv("DBPASSWORD"), "waves");
    echo "after";
    /*
    if ($db->connect_errno) {
        echo "Failed to connect to MYSQL";
        exit();
    }
     */

    return $db;
}

# function to close a database connection
function closeDb($db) {
    mysqli_close($db) or die("Failed to close database connection!");
}

# function to create a new user
function create_user($conn, $username, $password, $description) {
    # prepare query
    echo "preparing";
    $stmt = $conn->prepare("INSERT INTO users (username, password, description) VALUES (?, ?, ?)");

    # bind params
    $stmt->bind_param("sss", $username, $password, $description);


    $result = $stmt->execute();

    $stmt->close();


}



################################################


?>
