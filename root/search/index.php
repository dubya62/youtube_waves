<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .search-results {
            margin-top: 20px;
        }
        .result-item {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }
    </style>
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

            // $searchTerm = $_GET['query'];  // Get the search term from URL
            // $query = "SELECT * FROM filtered_clips WHERE 
            //         clip_title LIKE CONCAT('%', ?, '%') 
            //         OR user_description LIKE CONCAT('%', ?, '%') 
            //         OR clip_tag LIKE CONCAT('%', ?, '%')";
            
            // $stmt = $mysqli->prepare($query);
            // $searchTerm = '%' . $searchTerm . '%';  // Prepare the search term with wildcards
            // $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);  // Bind the search term to the query
            // $stmt->execute();
            // $result = $stmt->get_result();  // Fetch the result
            
            // // Process the result
            // while ($row = $result->fetch_assoc()) {
            //     echo $row['clip_title'] . " - " . $row['username'] . "<br>";
            // }

            
        ?>
    </div>
</body>
</html>