<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="../root.css">
</head>
<body>
    <h1>Search Results</h1>
    <form action="search.php" method="get">
        <input type="text" name="query" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    <div class="search-results">
        <?php
            include '../../includes/scripts.php';

            $conn = initDb();

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
                echo "<h2>Search Results:</h2>";
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
