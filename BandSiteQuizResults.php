<!--This is part of the assignment 3 example-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, fixed-scale=1.0">
    <title>TFC Quiz Results</title>
    <link rel="stylesheet" type="text/css" href="BandSiteStyleAlt.css">
</head>
<body>
    <h1>Thank you for completing the quiz</h1>
    <div class="container">
    <?php
    //connect to the server
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "quizResults";
    $sqlConnection = mysqli_connect($host, $dbUsername, $dbPassword);

    //check SQL connection
    if (!$sqlConnection){
        die("Connection Failed: " .mysqli_connect_error());
    }
    echo "<p style='position:fixed;bottom:3em;left:25px;'>Connected Successfully to SQL<br/></p>";

    //create new database
    $sqlCreate = "CREATE DATABASE quizResults";
    if(mysqli_query($sqlConnection, $sqlCreate)){
        echo "<p style='position:fixed;bottom:2em;left:25px;'>Database quizResults created successfully<br/></p>";
    }else{
        echo"<p style='position:fixed;bottom:2em;left:25px;'>ERROR: Could not execute $sqlCreate. " . mysqli_error($sqlConnection) . "<br/></p>";
    }

    //reconnect to sql, specifying the new database
    mysqli_close($sqlConnection);
    $dbConnection = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

    //create new table in database
    $sqlTable = "CREATE TABLE results(fname VARCHAR(64) NOT NULL, lname VARCHAR(64) NOT NULL, score VARCHAR(64) NOT NULL)";
    if (mysqli_query($dbConnection, $sqlTable)){
        echo "<p style='position:fixed;bottom:1em;left:25px;'>Table results created successfully<br/></p>";
    }else{
        echo "<p style='position:fixed;bottom:1em;left:25px;'>Error creating table: " . mysqli_error($dbConnection) . "<br/></p>";
    }
    
    //check for data in the post and get arrays and then attempt to add that data to the database
    if (isset($_GET['firstname']) && ($_GET['lastname'])){
        //Insert the new subscriber to the database
        $sqlInsert = "INSERT INTO results (fname, lname, score) VALUES (?,?,?)";
        $stmt = mysqli_prepare($dbConnection, $sqlInsert);
        if($stmt){
            mysqli_stmt_bind_param($stmt, "ssi", $FirstName, $LastName, $Score);
        }else{
            echo "<p style='position:fixed;bottom:0;left:25px;'>ERROR: Could not prpare query: $sqlInsert. " . mysqli_error($dbConnection) . "<br/></p>";
        }
        $FirstName = $_GET['firstname'];
        $LastName = $_GET['lastname'];
        //calculate score
        $Score = $_GET['q1']+$_GET['q2']+$_GET['q3']+$_GET['q4']+$_GET['q5']+$_GET['q6']+$_GET['q7'];
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


        //Display results from the database
        $uGot = "You got: ".$Score."<br/>";
        echo "<h2>".$uGot."</h2>";
        echo "Heres how you rank among other quizzers: <br/><br/>";
        $sqlSelect = "SELECT fname, lname, score FROM results ORDER BY score desc";
        $result = mysqli_query($dbConnection, $sqlSelect);
        if(mysqli_num_rows($result)>0){
            echo "<table>";
            echo "<tr><th class='tableName'>Quizzer</th> <th>Score</th>";
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                foreach($row as $x=>$x_value){
                $firstInitial = substr($x_value,0,1);
                if($x=='fname') echo "<td class='tableName'>$firstInitial";
                elseif($x=='lname') echo " $x_value</td>";
                else echo "<td>$x_value</td>";
            }
            echo "<tr>";
        }
        }else{
                echo "0 results";
            }
        }
        mysqli_close($dbConnection);
        
?>
</div>
</body>
<foot>
    <p>
        <a href="BandSiteHome.html">Home</a><span> | </span>
        <a href="BandSiteCalculator.html">Calculator</a><span> | </span>
        <a href="BandSiteQuiz.html">Music Quiz</a><span> | </span>
        <a href="BandSiteStore.html">Merch Store</a>
   </p>
</foot>
</html>