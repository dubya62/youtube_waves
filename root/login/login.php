<!DOCTYPE html>
<html>

    <head>
        <title>
            Youtube Waves
        </title>

        <link rel='stylesheet' type='text/css' href='../root.css'/>
        <link rel='stylesheet' type='text/css' href='login.css'/>
    </head>

    <body>
        <div id='loginBox'>

            <?php
                # if the user is already authenticated,
                # send them to the home page
                if (isset($_COOKIE["session"])){
                    echo "<script>window.location = '/index.html';</script>";
                }
            ?>

            <h1>
                Login:
            </h1>
            <form method='post'>
                <label for='username'>Username:</label>
                <input type='text' name='username'/>
                <br>
                <label for='password'>Password:</label>
                <input type='text' name='password'/>
                <br>
                <input type='submit' value='login'/>
            </form>

            <?php
                # add database functionality for the login form
                if (isset($_POST['username'])){
                    if (isset($_POST['password'])){
                        include '../../includes/scripts.php';

                        # open database connection
                        $conn = initDb();

                        $authenticated = authenticate_user($conn, $_POST['username'], $_POST['password']);

                        if ($authenticated){
                            echo "Authentication successful <BR>";
                            echo "Setting Cookie<BR>";
                            setcookie("session", get_cookie_val($conn, $_POST['username'], $_POST['password']), time() + (86400 * 30), "/");
                            echo "Cookie Set<BR>";
                        } else {
                            echo "<div id='statusBox'>Authentication Failed!<BR></div>";
                        }


                        # close database connection
                        closeDb($conn);
                    }
                }

            ?>
        </div>




    </body>

</html>