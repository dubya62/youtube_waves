<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube Waves - Login</title>

    <!-- Bulma CSS Framework -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">

    <!-- Dark Mode Custom CSS -->
    <style>
        :root {
            --primary-color: #006b3d;       /* Green */
            --secondary-color: #d35400;     /* Orange */
            --background-color: #2c2c2c;    /* Dark background */
            --card-background: #3c3c3c;     /* Card background */
            --text-color: #ffffff;          /* Light text */
            --secondary-text-color: #888;
        }

        /* Extend background across full viewport height */
        html, body {
            height: 100%;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        /* Center content vertically and ensure full viewport coverage */
        .section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #loginBox {
            min-width: 600px;
            padding: 2rem;
            border-radius: 8px;
            background-color: var(--card-background);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .button.is-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .button.is-primary:hover {
            background-color: var(--secondary-color);
        }

        .input, .textarea, .select select {
            background-color: #4c4c4c;
            border-color: #555;
            color: var(--text-color);
        }

        .input::placeholder, .textarea::placeholder {
            color: var(--secondary-text-color);
        }

        .label {
            color: var(--secondary-text-color);
        }
    </style>
</head>

<body>
    <section class="section">
        <div id="loginBox" class="box">
            <h1 class="title has-text-centered" style="color: var(--primary-color);">
                Log In
            </h1>

            <form method="post">
                <div class="field">
                    <label for="username" class="label">Username:</label>
                    <div class="control">
                        <input type="text" name="username" class="input" placeholder="Enter username" required>
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="label">Password:</label>
                    <div class="control">
                        <input type="password" name="password" class="input" placeholder="Enter password" required>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input type="submit" value="Log In" class="button is-primary is-fullwidth">
                    </div>
                </div>
            </form>

            <p class="has-text-centered mt-4" style="color: var(--secondary-text-color);">
                New user? <a href="/root/signup/signup.php" style="color: var(--primary-color);">Sign up</a>
            </p>

            <?php
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    include '../../includes/scripts.php';

                    // Open database connection
                    $conn = initDb();

                    // Attempt to authenticate the user
                    $authenticated = authenticate_user($conn, $_POST['username'], $_POST['password']);

                    // Close database connection
                    closeDb($conn);

                    if ($authenticated) {
                        echo "<script>window.location='/dashboard.php';</script>";
                    } else {
                        echo "<p class='has-text-danger has-text-centered mt-3'>Invalid username or password.</p>";
                    }
                }
            ?>
        </div>
    </section>
</body>
</html>