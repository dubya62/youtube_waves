<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Acc Name goes here</title>
    
    <!-- Bulma CSS Framework -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="./profile.css">
</head>
<body>
    <!-- Navbar -->
    <!-- <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Profile</a>
            <div class="d-flex">
                <button id="theme-toggle" class="btn btn-primary">Profile img</button>
    -->

    <?php 
        include '../../scripts.php';
        // get the username
        $conn = initDb();
        $user_id = getUserIdByCookie($conn);
        $username = getUsername($conn, $user_id);
    ?>

    <title><?php echo $username; ?></title>
    <!-- <link rel="stylesheet" href="../root.css"/>
    <link rel="stylesheet" href="profile.css"/>
    <link rel="stylesheet" href="clips.css"/>
    <link rel="stylesheet" href="playlists.css"/> -->
</head>
<body>
    <!-- Profile Section -->
    <section class="section">
        <!-- Profile Image -->
        <figure class="image is-128x128 is-inline-block mb-4">
            <img src="../img/bara.jpg" alt="Profile Image" class="is-rounded">
        </figure>

        <!-- Profile Name -->
        <h2 class="title is-primary"><?php echo htmlspecialchars($username); ?></h2>

        <div class="columns is-mobile is-centered has-text-centered mt-4">
            <div class="column stat" id="followers">
                <h3><?php echo getSubscriberCount($conn, $user_id); ?>
                <p>Followers</p>
            </div>
            <div class="column stat" id="following">
                <h3><?php echo getSubscriptionCount($conn, $user_id); ?></h3>
                <p>Following</p>
            </div>
            <div class="column stat" id="wavecount">
                <h3><?php echo getWaveCount($conn, $user_id); ?></h3>
                <p>Waves</p>
            </div>
        </div>
    </section>

    <!-- Clips and Playlists -->
    <div class="tabs is-centered is-boxed mt-5">
        <ul>
            <li id="clips-tab" class="is-active">
                <a onclick="showTab('clips')">Clips</a>
            </li>
            <li id="playlists-tab">
                <a onclick="showTab('playlists')">Playlists</a>
            </li>
        </ul>
    </div>

    <!-- Content for Clips and Playlists -->
    <div id="clips" class="tab-content is-active">
        <div id="clip-list" class="content is-centered">
            <!-- JavaScript dynamically loads clips here -->

            

        </div>
    </div>

    <div id="playlists" class="tab-content">
        <div id="playlists-list" class="content">
            <!-- JavaScript dynamically loads playlists here -->

        </div>
    </div>

    <script src="./profile.js"></script>

    <script>
        // Make viewClipsActive run as page loads
        // window.onload = viewClipsActive;

    </script>
    <script src="profile.js"></script>
    <?php 
        include '../navigationBar/navigationBar.php'; 
        closeDb($conn);
    ?>
</body>
</html>