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
    <form action="search.php" method="get">
        <input type="text" name="query" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <div class="search-results">
        <?php
        if (isset($_GET['query'])) {
            $query = htmlspecialchars($_GET['query']);
            // Dummy data for demonstration purposes
            $results = [
                "Result 1 for $query",
                "Result 2 for $query",
                "Result 3 for $query",
            ];

            if (count($results) > 0) {
                foreach ($results as $result) {
                    echo "<div class='result-item'>$result</div>";
                }
            } else {
                echo "<p>No results found for '$query'</p>";
            }
        }
        ?>
    </div>
</body>
</html>