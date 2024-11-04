<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        include '../../includes/scripts.php';
        // get the username
        $conn = initDb();
        $user_id = getUserIdByCookie($conn);
        $username = getUsername($conn, $user_id);
    ?>

    <title><?php echo $username; ?></title>
    <link rel="stylesheet" href="../root.css"/>
    <link rel="stylesheet" href="profile.css"/>
    <link rel="stylesheet" href="clips.css"/>
    <link rel="stylesheet" href="playlists.css"/>
</head>
<body>
    <div id="acc-info">
        <h2>
            <?php
                echo htmlspecialchars($username);

            ?>
        </h2>

        <img id="acc-img" src="../img/bara.jpg"/>

        <!-- NOTE: -->
        <!-- The filler divs are solely for making flex work. No functionality -->
        <div id="acc-stats" class="grey-bg">
            <div class="stat" id="followers">
            <h3><?php echo getSubscriberCount($conn, $user_id); ?></h3>
                <p>Followers</p>
            </div>
            <div class="stat" id="following">
            <h3><?php echo getSubscriptionCount($conn, $user_id); ?></h3>
                <p>Following</p>
            </div>
            <div class="stat" id="wavecount">
            <h3><?php echo getWaveCount($conn, $user_id); ?></h3>
                <p>Waves</p>
            </div>
        </div>
        <button id="follow-btn" class="green-bg">Follow</button>
    </div>

    <!-- Includes navbar for clip/playlist and clips/playlists list-->
    <div id="clip-div">
        <!-- Used to select between profile's clips and playlists -->
        <div id="clip-nav-bar">
            <div 
                id="show-clips" class="clip-nav active"
                onclick="viewClipsActive()"
            >
                Clips
            </div>
            <div 
                id="show-playlists" class="clip-nav"
                onclick="viewPlaylistsActive()"
            >
                Playlists
            </div>
        </div>        
        
        <!-- 
        Div where list of user's clips goes. 
        Empty now, as info is dynamically added by JS 
        -->
        <div id="clip-list">
        
        </div>

        <!-- 
        Div where list of user's playlists goes. 
        Empty now, as info is dynamically added by JS 
        -->
        <div id="playlists-list">
        
        </div>

    </div>

    <script src="profile.js"></script>
    <?php 
        include '../navigationBar/navigationBar.php'; 
        closeDb($conn);
    ?>
</body>
</html>
