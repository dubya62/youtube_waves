<!DOCTYPE html>
<html>

    <head>
        <title>
            Youtube Waves
        </title>

        <link rel='stylesheet' type='text/css' href='css/root.css'/>
        <link rel='stylesheet' type='text/css' href='css/login.css'/>
    </head>

    <body>
        <div id='loginBox'>
            <h1>
                Sign-Up:
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
                if (isset($_POST['username'])){
                    if (isset($_POST['password'])){
                        # add database functionality for the login form
                        include 'scripts.php';


                        # open database connection
                        $conn = initDb();

                        $created = create_user($conn, $_POST['username'], $_POST['password'], "N/A");

                        # close database connection
                        closeDb($conn);

                        if ($created){
                            echo "<script>window.location='login.php';</script>";
                        }

                    }
                }
            ?>
        </div>

    </body>

</html>
