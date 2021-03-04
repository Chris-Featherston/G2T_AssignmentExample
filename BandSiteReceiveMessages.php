<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TFC Admin</title>
    <link rel="stylesheet" type="text/css" href="BandSiteStyleAlt.css">

</head>
<body>
    <h1>Hello band, your messages are as follows:</h1>
    <div class="container">
    <?php
        //connect to the database
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "bandMessages";
        $dbConnection = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
        
        //check connection
        if (!$dbConnection){
            die("Connection Failed: " .mysqli_connect_error());
        }


        //Display results from the database
        $sqlSelect = "SELECT fname, lname, msg FROM messages";
        $result = mysqli_query($dbConnection, $sqlSelect);
        if(mysqli_num_rows($result)>0){
            echo "<table id='messageTable'>";
            echo "<tr><th class='tableName'>Name</th> <th>Message</th></tr>";
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                foreach($row as $x=>$x_value){
                    $firstInitial = substr($x_value,0,1);
                    if($x=='fname') echo "<td class=tableName>$firstInitial";
                    elseif($x=='lname') echo " $x_value</td>";
                    else echo "<td>$x_value</td>";
                }
                echo "</tr>";
            }
        }else{
                echo "Sorry, yall have no messages yet";
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