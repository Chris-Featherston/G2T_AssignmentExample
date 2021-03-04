<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TFC Temp</title>
</head>
<body>
    <script>
        function confirmMessage(){
            var msg = '<?php echo $_GET['message']?>';
            var cnfrmmsg = "Your message to the band is: ".concat(msg).concat(".\r\nPress okay to confirm or cancel to return home without submitting");
            var cnfrm = confirm(cnfrmmsg);
            if (cnfrm == true){
                //ADD INFO TO DATABASE
                <?php
                //connect to the server
                $host = "localhost";
                $dbUsername = "root";
                $dbPassword = "";
                $dbName = "bandMessages";
                $sqlConnection = mysqli_connect($host, $dbUsername, $dbPassword);
                
                //check SQL connection
                if (!$sqlConnection){
                    die("Connection Failed: " .mysqli_connect_error());
                }
                echo 'console.log("Connected Successfully to SQL");';

                //create new database
                $sqlCreate = "CREATE DATABASE bandMessages";
                if(mysqli_query($sqlConnection, $sqlCreate)){
                    echo "console.log('Database bandMessages created successfully');";
                }else{
                    echo 'console.log("ERROR: Could not execute database creation");';
                }

                //reconnect to sql, specifying the new database
                mysqli_close($sqlConnection);
                $dbConnection = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

                //create new table in database
                $sqlTable = "CREATE TABLE messages(fname VARCHAR(64) NOT NULL, lname VARCHAR(64) NOT NULL, email VARCHAR(64) NOT NULL, mobile VARCHAR(64), msg VARCHAR(64) NOT NULL PRIMARY KEY)";
                if (mysqli_query($dbConnection, $sqlTable)){
                    echo "console.log('Table messages created successfully');";
                }else{
                    echo "console.log('Error creating table');";
                }

                //check for data in the post and get arrays and then attempt to add that data to the database
                if (isset($_GET['firstname']) && ($_GET['lastname']) && ($_GET['email']) && ($_GET['tel']) && ($_GET['message'])){
                    //Insert the new subscriber to the database
                    $sqlInsert = "INSERT INTO messages (fname, lname, email, mobile, msg) VALUES (?,?,?,?,?)";
                    $stmt = mysqli_prepare($dbConnection, $sqlInsert);
                    if($stmt){
                        mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $mobile, $msg);
                    }else{
                        echo "console.log('ERROR: Could not prpare query');";
                    }
                    $firstName = $_GET['firstname'];
                    $lastName = $_GET['lastname'];
                    $email = $_GET['email'];
                    $mobile = $_GET['tel'];
                    $msg = $_GET['message'];
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                }
                mysqli_close($dbConnection);


                ?>
                //return to homescreen
                location.replace("BandSiteHome.html");
            } else {
                location.replace("BandSiteHome.html");
            }
        }
        confirmMessage();
    </script>
</body>
</html>