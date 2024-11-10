<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Acc Name goes here</title>
    
    <!-- Bulma CSS Framework -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="./profile.css">
    <style>
        .green {
            background-color: var(--color-green);
        }

        .navbar-dropdown {
            background-color: #3c3c3c; /* Change this color to match your design */
            border-radius: 8px; /* Optional: Add rounded corners */
            border: 1px solid #2c2c2c; /* Optional: Add a border for a defined edge */
            z-index: 1000;
        }

        .search-bar input {
            width: 300px;

            padding: 5px;
            font-size: 16px;
            border-radius: 15px;    
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: var(--color-bg-primary);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <!-- <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Profile</a>
            <div class="d-flex">
                <button id="theme-toggle" class="btn btn-primary">Profile img</button>
    -->

    <header>

    <div onclick="window.href='/root/home_page/home_page.php'"s>
        <img src="logo.png" alt="Logo" style="width: 100px; height: 60px">
    </div>

    <div class="search-bar">
        <!-- Search Form -->
        <!-- <form method="GET">
            <input type="text" name="query" placeholder="Search for something..." required>
            <button type="submit">Search</button>
        </form> -->
        <form class="field" method="GET">
            <div class="control">
                <input class="input" name="query" placeholder="Search for something..." required>
                <button class="button green" type="submit">Search</button>
            </div>
        </form>
    </div>


    <div class="navbar-item has-dropdown is-hoverable">
    </div>
</header>

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