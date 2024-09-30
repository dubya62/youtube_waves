<html>
    <head>

    </head>

    <body>
        <?php
            # add database functionality for the login form
            include 'scripts.php';


            # open database connection
            $conn = initDb();

            if (isset($_POST['username'])){
                if (isset($_POST['password'])){
                    create_user($conn, $_POST['username'], $_POST['password'], "N/A");
                }
            }

            # close database connection
            closeDb($conn);

        ?>

    </body>
</html>
