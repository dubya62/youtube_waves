<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to YouTube Waves!</title>
    <link rel="stylesheet" href="../root.css"/>
    <link rel="stylesheet" href="about.css"/>
</head>
<body>
    
    <div id="landing-container">
        <h1 class="welcome-text">Welcome to YouTube Waves!</h1>
        <p class="sub-text">Your go-to platform for sharing and discovering fun audios.</p>

        <div id="button-container">
            <button class="landing-btn green-bg" onclick="window.location.href='../login/login.php'">Login</button>
            <button class="landing-btn orange-bg" onclick="window.location.href='../signup/signup.php'">Sign Up</button>
        </div>
    </div>

    <?php include '../navigationBar/navigationBar.php'; ?>
</body>
</html>
