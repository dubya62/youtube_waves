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

            <form>
                
                <!-- Username Section -->
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" placeholder="Username" class="input-field"/>
                </div>

                <!-- Password Section -->
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" placeholder="********" class="input-field"/>
                </div>

                <!-- Save Button -->
                <button id="save-settings" class="green-bg">Save Changes</button>

                <!-- PHP to update username and password -->
                <?php 
                    include '../../includes/scripts.php';
                    # open database connection
                    $conn = initDb();
                    # get username
                    $username = $_COOKIE["session"];
                    $sql = "SELECT * FROM users WHERE username='$username'";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();

                    # get password
                    $password = $row["password"];

                    # compare username and password to submission of username/password
                    if (isset($_POST['username'])){
                        if (isset($_POST['password'])){
                            $new_username = $_POST['username'];
                            $new_password = $_POST['password'];

                            # if there is an updated username or password, update the database
                            if ($new_username != $username){
                                $sql = "UPDATE users SET username='$new_username' WHERE username='$username'";
                                $conn->query($sql);
                                $username = $new_username;
                            }

                            if ($new_password != $password){
                                $sql = "UPDATE users SET password='$new_password' WHERE username='$username'";
                                $conn->query($sql);
                                $password = $new_password;
                            }
                        }
                    }

                    # close database connection
                    $conn->close();
                ?>
            </form>
        </div>
    </div>

    <?php include '../navigationBar/navigationBar.php'; ?>
</body>
</html>
