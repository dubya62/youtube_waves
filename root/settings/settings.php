<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../root.css"/>
    <link rel="stylesheet" href="settings.css"/>

</head>
<body>
    <div id="settings-info">
        <h2>Account Settings</h2>

        <img id="acc-img" src="../img/bara.jpg" alt="Profile Image"/>

        <div id="settings-form">

            <form method="post">
                
                <!-- Username Section -->
                <div class="form-group">
                    <label for="username">New Username:</label>
                    <input type="text" id="username" placeholder="Username" class="input-field" name="username"/>
                </div>

                <!-- Password Section -->
                <div class="form-group">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" placeholder="********" class="input-field" name="password"/>
                </div>

                <!-- Save Button -->
                <input type="submit" id="save-settings" class="green-bg" value="Save Changes"/>

                <!-- PHP to update username and password -->
                <?php 
                    include '../../includes/scripts.php';
                    # open database connection
                    $conn = initDb();
                    # get username
                    $username = getUsername($conn, getUserIdByCookie($conn)); // $_COOKIE["session"];
                    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username=?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $stmt->bind_result($result1, $result2);


                    $rows = 0;
                    while ($stmt->fetch()){
                        $rows++;
                    }
                    if ($rows == 0){
                        // silent error
                        //echo "Current User does not exist!";
                        return;
                    }

                    $username = $result1;
                    $password = $result2;

                    $stmt->free_result();
                    # get password

                    # compare username and password to submission of username/password
                    if (isset($_POST['username'])){
                        if (isset($_POST['password'])){
                            $new_username = $_POST['username'];
                            $new_password = $_POST['password'];

                            # if there is an updated username or password, update the database
                            if ($new_username != $username){
                                $sql = $conn->prepare("UPDATE users SET username=? WHERE username=?");
                                $sql->bind_param("ss", $new_username, $username);
                                $sql->execute();
                                $username = $new_username;
                            }

                            if ($new_password != $password){
                                $sql = $conn->prepare("UPDATE users SET password=? WHERE username=?");
                                $hashed_new_password = hash("sha256", $new_password);
                                $sql->bind_param("ss", $hashed_new_password, $username);
                                $sql->execute();
                                setcookie("session", get_cookie_val($conn, $username, $new_password), time() + (86400 * 30), "/");
                            }
                        }
                    }

                    # close database connection
                    closeDb($conn);
                ?>
            </form>
        </div>
    
    <!-- Delete Account Button -->
    <div>

        <h3>Ready to Wave Goodbye?</h3>
        <form method="post">
            <input type=button id="delete-account" value="Delete Account"/>
        </form>
        <?php
            $conn = initDb();
            $user = getUsername($conn, getUserIdByCookie($conn));
            deleteUser($conn, $user);
            closeDb($conn);
        ?>

    </div>

    </div>

    <!-- Navigation Bar -->
    <?php include '../navigationBar/navigationBar.php'; ?>

</body>
<script src="../../node_modules/bulma-toast/dist/bulma-toast.min.js" defer></script>
<script src="settings.js" defer></script>
</html>
