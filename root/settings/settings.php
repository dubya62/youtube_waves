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

        <div id="settings-form" class="grey-bg">
            <form>
                <!-- Username Section -->
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" value="NotACapybara" class="input-field"/>
                    /*TODO: Retrieve username from database and be able to update values*/
                </div>

                <!-- Password Section -->
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" placeholder="********" class="input-field"/>
                    /*TODO: Retrieve password from database and be able to update values*/
                </div>

                <!-- Save Button -->
                <button id="save-settings" class="green-bg">Save Changes</button>
            </form>
        </div>
    </div>

    <script src="settings.js"></script>
    <?php include '../navigationBar/navigationBar.php'; ?>
</body>
</html>
