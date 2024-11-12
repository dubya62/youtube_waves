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
                    <button class="button green has-text-white" type="submit">Search</button>
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
                <a class="navbar-item" href="/root/logout.php">
                    Log Out
                </a>
            </div>
        </div>
    </header>
    <div class="search-results">
        <h1>Search Results</h1>

        <form action="search.php" method="get" id="filterForm" class="box has-background-grey-dark mb-4">
            <div class="field is-grouped is-grouped-multiline">
                <!-- Search Type Dropdown -->
                <div class="control">
                    <label class="label has-text-white">Search Type:</label>
                    <div class="select is-dark">
                        <select name="search_type" id="searchType" onchange="toggleFormFields()">
                            <option value="clips" <?php echo (isset($_GET['search_type']) && $_GET['search_type'] == 'clips') ? 'selected' : ''; ?>>Waves</option>
                            <option value="users" <?php echo (isset($_GET['search_type']) && $_GET['search_type'] == 'users') ? 'selected' : ''; ?>>Users</option>
                        </select>
                    </div>
                </div>

                <!-- Wave Title Filter -->
                <div class="control ml-3 wave-field">
                    <label class="label has-text-white">Wave Title:</label>
                    <input type="text" name="wave_title" class="input is-dark" placeholder="Wave Title" value="<?php echo isset($_GET['wave_title']) ? htmlspecialchars($_GET['wave_title']) : ''; ?>">
                </div>

                <!-- Wave Tag Filter -->
                <div class="control ml-3 wave-field">
                    <label class="label has-text-white">Wave Tag:</label>
                    <input type="text" name="wave_tag" class="input is-dark" placeholder="Enter Tag" value="<?php echo isset($_GET['wave_tag']) ? htmlspecialchars($_GET['wave_tag']) : ''; ?>">
                    </div>

                <!-- Username Filter -->
                <div class="control ml-3 user-field" style="display: none;">
                    <label class="label has-text-white">Username:</label>
                    <input type="text" name="username_search" class="input is-dark" placeholder="Enter Username" value="<?php echo isset($_GET['username_search']) ? htmlspecialchars($_GET['username_search']) : ''; ?>">
                </div>

                <!-- Submit Button -->
                <div class="control ml-3">
                    <button type="submit" class="button green has-text-white">Apply Filters</button>
                </div>
            </div>
        </form>

        <?php
            include '../../includes/scripts.php';
            $conn = initDb();

            function searchDB($search_term, $search_type, $conn, $username_search = '', $wave_title = '', $wave_tag = '') {
                $search_term = $conn->real_escape_string($search_term);
                $username_search = $conn->real_escape_string($username_search);
                $wave_title = $conn->real_escape_string($wave_title);
                $wave_tag = $conn->real_escape_string($wave_tag);
                $sql_search_query = "";
            
                if ($search_type === 'clips') {
                    $sql_search_query = "
                    SELECT DISTINCT c.id, c.name, c.time, u.username AS owner_name
                    FROM clips c
                    JOIN users u ON u.id = c.owner
                    LEFT JOIN clip_tags ct ON ct.clip_id = c.id
                    LEFT JOIN tags t ON ct.tag_id = t.id
                    WHERE 1=1
                    ";
            
                    if (!empty($wave_title)) {
                        $sql_search_query .= " AND c.name LIKE '%$wave_title%'";
                    }
            
                    if (!empty($wave_tag)) {
                        $sql_search_query .= " AND t.tag LIKE '%$wave_tag%'";
                    }
            
                } elseif ($search_type === 'users') {
                    if (!empty($username_search)) {
                        $sql_search_query = "
                        SELECT u.id, u.username
                        FROM users u
                        WHERE u.username LIKE '%$username_search%'
                        ";
                    }
                }
            
                // Check if the query string is non-empty
                if (!empty($sql_search_query)) {
                    $result = $conn->query($sql_search_query);
                    if (!$result) {
                        // Log or display the SQL error for debugging
                        echo "SQL Error: " . $conn->error;
                        return false;
                    }
                    return $result;
                } else {
                    return false;
                }
            }
            
            $search_term = isset($_GET['query']) ? $_GET['query'] : '';
            $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'clips';
            $username_search = isset($_GET['username_search']) ? $_GET['username_search'] : '';
            $wave_title = isset($_GET['wave_title']) ? $_GET['wave_title'] : '';
            $wave_tag = isset($_GET['wave_tag']) ? $_GET['wave_tag'] : '';            

            $result = null;
            // Execute the query function
            if ($search_type == "users") {
                $result = searchDB($search_term, $search_type, $conn, $username_search);
            } else {
                $result = searchDB($search_term, $search_type, $conn, '', $wave_title, $wave_tag);
            }

            // Check if any rows are returned
            if ($result->num_rows > 0) {
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    if ($search_type === 'clips') {
                        // Display clip search results
                        echo "<li>Clip: " . htmlspecialchars($row['name']) . 
                             " | Owner: " . htmlspecialchars($row['owner_name']) . 
                             " | Tags: " . implode(", ", getClipTagNames($conn, $row['id'])) . 
                             " | Date: " . htmlspecialchars($row['time']) . "</li><br>";
                    } elseif ($search_type === 'users') {
                        // Display user search results
                        echo "<li>User: " . htmlspecialchars($row['username']) . "</li><br>";
                    }
                }
                echo "</ul>";
            } else {
                echo "No results found.";
            }
 
            // Close the connection
            closeDb($conn);
        ?>
    </div>
    <?php include '../navigationBar/navigationBar.php'; ?>
    
    <script>
        function toggleFormFields() {
            const searchType = document.getElementById('searchType').value;
            const waveFields = document.querySelectorAll('.wave-field');
            const userField = document.querySelector('.user-field');

            if (searchType === 'clips') {
                waveFields.forEach(field => field.style.display = 'block');
                userField.style.display = 'none';
            } else if (searchType === 'users') {
                waveFields.forEach(field => field.style.display = 'none');
                userField.style.display = 'block';
            }
        }

        // Run the function on page load to set the initial state
        document.addEventListener('DOMContentLoaded', toggleFormFields);
    </script>
</body>
</html>
