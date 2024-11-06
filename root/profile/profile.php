<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
        include '../../includes/scripts.php';
        // get the username
        $conn = initDb();
        $mine = 0;
        if (isset($_GET["user_id"])){
            $user_id = $_GET["user_id"];
            if ($user_id == getUserIdByCookie($conn)){
                $mine = 1;
            }
        } else {
            $user_id = getUserIdByCookie($conn);
            $mine = 1;
        }
        $username = getUsername($conn, $user_id);
    ?>

    <title><?php echo $username; ?></title>
    <link rel="stylesheet" href="../root.css"/>
    <link rel="stylesheet" href="profile.css"/>
    <link rel="stylesheet" href="clips.css"/>
    <link rel="stylesheet" href="playlists.css"/>
    <style>
        .upload-form{
            align: center;
            text-align: center;
            align-content: center;
        }
    </style>
</head>
<body>
    <div id="acc-info">
        <h2>
            <?php
                echo htmlspecialchars($username);
            ?>
        </h2>

        <?php
            if (isset($_FILES['image']['tmp_name'])){
                $uploadPath = "images/" . $user_id;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath);
            }

        ?>
        <?php
            echo '<form class=\'upload-form\' method=\'post\' enctype="multipart/form-data"> <img id="acc-img" alt=\'No Profile Picture Uploaded\' src=\'images/' . $user_id . '\' style=\'border-radius:50%\'/> <br> ';
            if ($mine){
                echo '<input type="file" name=\'image\'/> <br> <input type=\'submit\' class="clickable" value=\'update\' accept="image/*,image/gif"/>';
            }
            echo '</form>';
        
        ?>

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
