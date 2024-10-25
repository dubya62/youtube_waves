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
    <form action="index.php" method="get">
        <input type="text" name="query" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    <div class="search-results">
        <?php
            include '../../includes/scripts.php';
            $search_term = $_GET['search_term'];

            // Escape special characters for security (prevent SQL injection)
            $search_term = $conn->real_escape_string($search_term);
            
            // SQL query to search in the `owner`, `name`, and `tags` fields
            $sql_search_query = "
            SELECT clips.id, clips.name, clips.time, users.username AS owner_name, tags.tag AS tag_name
            FROM clips
            LEFT JOIN users ON clips.owner = users.id
            LEFT JOIN tags ON clips.tags = tags.id
            WHERE 
                clips.name LIKE '%$search_term%' OR 
                users.username LIKE '%$search_term%' OR 
                tags.tag LIKE '%$search_term%'
            ";

            // Execute the query
            $result = $conn->query($sql);

            // Check if any rows are returned
            if ($result->num_rows > 0) {
                // Display the search results
                echo "<h2>Search Results:</h2>";
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>Clip: " . $row['name'] . " | Owner: " . $row['owner_name'] . " | Tag: " . $row['tag_name'] . " | Date: " . $row['time'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "No results found for '$search_term'";
            }
 
            // Close the connection
            $conn->close();
        ?>
    </div>
    <?php include '../navigationBar/navigationBar.php'; ?>
</body>
</html>