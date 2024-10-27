<!DOCTYPE html>
<html>

    <head>
        <title>
            Youtube Waves
        </title>

        <link rel='stylesheet' type='text/css' href='../root.css'/>
        <link rel='stylesheet' type='text/css' href='signup.css'/>
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
            <br>
            <br>
            <strong>Already a user? <a href="/login/login.php">log in</a></strong>

            <?php
                if (isset($_POST['username'])){
                    if (isset($_POST['password'])){
                        # add database functionality for the login form
                        include '../../includes/scripts.php';

                        # open database connection
                        $conn = initDb();

                        $created = create_user($conn, $_POST['username'], $_POST['password'], "N/A");

                        # close database connection
                        closeDb($conn);

                        if ($created){
                            echo "<script>window.location='/login/login.php';</script>";
                        }

                    }
                }
            ?>
        </div>

    </body>

</html>
