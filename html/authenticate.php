<html>
    <head>

    </head>

    <body>
        <?php
            # add database functionality for the login form
            include 'scripts.php';

            # open database connection
            $conn = initDb();

            $authenticated = 0;

            if (isset($_POST['username'])){
                if (isset($_POST['password'])){
                    $authenticated = authenticate_user($conn, $_POST['username'], $_POST['password']);
                }
            }

            if ($authenticated){
                echo "Authentication succesfull <BR>";
                echo "Setting Cookie<BR>";
                setcookie("session", get_cookie_val($conn, $_POST['username'], $_POST['password']), time() + (86400 * 30), "/");
                echo "Cookie Set<BR>";
            }


            # close database connection
            closeDb($conn);

        ?>

    </body>
</html>
