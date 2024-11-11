<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="../root.css">
</head>
<body>

    <header>

        <div>
            <img src="../home_page/logo.png" alt="Logo" style="width: 100px; height: 60px">
        </div>

        <div class="search-bar">
            <form class="field" method="GET">
                <div class="control">
                    <input class="input" name="query" placeholder="Search for something..." required>
                    <button class="button green" type="submit">Search</button>
                </div>
            </form>
        </div>


        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
                <figure class="image">
                    <img src="../home_page/profile_icon.png" alt="Profile" style="width: 40px; height: 40px;">
                </figure>
            </a>

            <div class="navbar-dropdown is-right">
                <a class="navbar-item" href="/root/profile/profile.php">
                    Profile
                </a>
                <a class="navbar-item" href="/root/settings/settings.php">
                    Settings
                </a>
                <hr class="navbar-divider">
                <a class="navbar-item" href="/root/logout.php">
                    Log Out
                </a>
            </div>
        </div>
    </header>
    <div class="search-results">
        <h1>Search Results</h1>

        <div class="box has-background-grey-dark mb-4">
            <div class="field is-grouped is-grouped-multiline">
                <div class="control">
                    <div class="tags has-addons">
                        <span class="tag is-dark">Filter 1</span>
                        <button class="tag is-delete"></button>
                    </div>
                </div>
                <div class="control">
                    <div class="tags has-addons">
                        <span class="tag is-dark">Filter 2</span>
                        <button class="tag is-delete"></button>
                    </div>
                </div>
                <div class="control">
                    <div class="tags has-addons">
                        <span class="tag is-dark">Filter 3</span>
                        <button class="tag is-delete"></button>
                    </div>
                </div>
                <!-- Add more filter controls as needed -->
            </div>
        </div>

        <?php
            include '../../includes/scripts.php';

            $conn = initDb();
            $search_term = "";
            if (isset($_GET['query'])) {
                $search_term = $_GET['query'];
            }

            // Escape special characters for security (prevent SQL injection)
            $search_term = $conn->real_escape_string($search_term);
            
            // SQL query to search in the `owner`, `name`, and `tags` fields
            $sql_search_query = "
            SELECT DISTINCT c.id, c.name, c.time, u.username AS owner_name
            FROM clips c, users u, tags t, clip_tags ct
            WHERE 
                u.id=c.owner AND ct.tag_id=t.id AND ct.clip_id=c.id AND
                (c.name LIKE '%$search_term%' OR 
                u.username LIKE '%$search_term%' OR 
                t.tag LIKE '%$search_term%')
            ";

            // Execute the query
            $result = $conn->query($sql_search_query);

            // Check if any rows are returned
            if ($result->num_rows > 0) {
                // Display the search results
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>Clip: " . $row['name'] . " | Owner: " . $row['owner_name'] . " | Tags: " . implode(", ", getClipTagNames($conn, $row['id'])) . " | Date: " . $row['time'] . "</li><BR>";
                }
                echo "</ul>";
            } else {
                echo "No results found for '$search_term'";
            }
 
            // Close the connection
            closeDb($conn);
        ?>
    </div>
    <?php include '../navigationBar/navigationBar.php'; ?>
</body>
</html>
