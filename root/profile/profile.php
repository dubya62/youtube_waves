<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acc Name goes here</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./profile.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Profile</a>
            <div class="d-flex">
                <button id="theme-toggle" class="btn btn-primary">Profile img</button>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <section class="container text-center mb-5">
        <h2>Capybara</h2>

        <img id="acc-img" src="../img/bara.jpg" alt="Profile Picture" class="img-fluid">

        <!-- Account Stats -->
        <div class="row mt-4 justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">57</h3>
                        <p class="card-text">Followers</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">70.0k</h3>
                        <p class="card-text">Following</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">320</h3>
                        <p class="card-text">Waves</p>
                    </div>
                </div>
            </div>
        </div>

        <button id="follow-btn" class="btn btn-primary mt-4">Follow</button>
    </section>

    <!-- Clips and Playlists -->
    <section class="container">
        <!-- Clips and Playlists Navbar -->
        <ul class="nav nav-tabs justify-content-center mb-4" id="myTab" role="tablist">
            <li class="nav-item">
                <p class="nav-link active" id="show-clips" data-bs-toggle="tab" onclick="viewClipsActive()">Clips</p>
            </li>
            <li class="nav-item">
                <p class="nav-link" id="show-playlists" data-bs-toggle="tab" onclick="viewPlaylistsActive()">Playlists</p>
            </li>
        </ul>

        <!-- Clips List -->
        <div id="clip-list" class="tab-content active-tab">
            <!-- Dynamically generated content goes here -->
        </div>

        <!-- Playlists List -->
        <div id="playlists-list" class="tab-content">
            <!-- Dynamically generated content goes here -->
        </div>
    </section>

<<<<<<< HEAD
    <script src="profile.js"></script>
    <?php include '../navigationBar/navigationBar.php'; ?>
=======
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="./profile.js"></script>

    <script>
        // Make viewClipsActive run as page loads
        window.onload = viewClipsActive;

    </script>
>>>>>>> 61485ed3bd3fdf1a06c29fc2361a04f87a56c0f8
</body>
</html>