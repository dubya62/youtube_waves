<html>
    <head>

    </head>

    <body>
        <?php
            # add database functionality for the login form
            include 'scripts.php';


            #$_POST['username'] = "admin";
            #$_POST['password'] = "admin_pass";


            # open database connection
            echo "here0";
            $conn = initDb();

            echo "here1";
            if (isset($_POST['username'])){
                if (isset($_POST['password'])){
                    echo "here2";
                    create_user($conn, $_POST['username'], $_POST['password'], "N/A");
                }
            }
            echo "here3";

            # close database connection
            closeDb($conn);

        ?>

    </body>
</html>
