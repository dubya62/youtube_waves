<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile:
        <?php
            include '../../includes/scripts.php';
        ?>
        <?php
            $conn = initDb();
            echo htmlspecialchars(getUsername($conn, getUserIdByCookie($conn)));
            closeDb($conn);
        ?>
    </title>
    <link rel="stylesheet" href="../root.css"/>
    <link rel="stylesheet" href="profile.css"/>
    <link rel="stylesheet" href="clips.css"/>
    <link rel="stylesheet" href="playlists.css"/>
</head>
<body>

    <div id="acc-info">
        <h2>
            <?php
                // put the username on the screen
                $conn = initDb();
                echo htmlspecialchars(getUsername($conn, getUserIdByCookie($conn)));
                closeDb($conn);
            ?>
        </h2>

        <img id="acc-img" src="../img/bara.jpg"/>

        <!-- NOTE: -->
        <!-- The filler divs are solely for making flex work. No functionality -->
        <!-- Technically, Followers and Following are the same thing as of now. -->
        <div id="acc-stats" class="grey-bg">
            <div class="stat" id="followers">
                <h3>
                   <?php
                        $conn = initDb();

                        $user = getUsername($conn, getUserIdByCookie($conn));
                        try {
                            // get number of accounts following this user
                            echo htmlspecialchars(getSubscriberCount($conn, $user));

                        } catch (Exception $e){
                            echo "0";
                        }
                    ?>
                </h3>
                <p>Followers</p>
            </div>
            <div class="stat" id="following">
                <h3>
                    <?php
                        $conn = initDb();
                        try {
                            $following = getFollowing($conn);
                            // count the number of following
                            echo count($following);

                        } catch (Exception $e){
                            echo "0";
                        }
                        closeDb($conn);
                    ?>
                </h3>
                <p>Following</p>
            </div>

            <!-- NOTE: -->
            <!-- This does not seem to be retreiving a number fo waves -->
            <div class="stat" id="wavecount">
                <h3>
                    <?php
                        $conn = initDb();
                        try {
                            $wavecount = getClipsByCookie($conn);

                            // count the number of waves
                            echo count($wavecount);

                        } catch (Exception $e){
                            echo "0";
                        }
                        closeDb($conn);
                    ?>
                </h3>
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
    <?php include '../navigationBar/navigationBar.php'; ?>
</body>
</html>
