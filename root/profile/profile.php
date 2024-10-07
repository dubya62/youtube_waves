<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acc Name goes here</title>
    <link rel="stylesheet" href="../root.css"/>
    <link rel="stylesheet" href="profile.css"/>
    <link rel="stylesheet" href="clips.css"/>
    <link rel="stylesheet" href="playlists.css"/>
</head>
<body>
    <div id="acc-info">
        <h2>NotACapybara</h2>

        <img id="acc-img" src="../img/bara.jpg"/>

        <!-- NOTE: -->
        <!-- The filler divs are solely for making flex work. No functionality -->
        <div id="acc-stats" class="grey-bg">
            <div class="stat" id="followers">
                <h3>57</h3>
                <p>Followers</p>
            </div>
            <div class="stat" id="following">
                <h3>70.0k</h3>
                <p>Following</p>
            </div>
            <div class="stat" id="wavecount">
                <h3>320</h3>
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
</body>
</html>
