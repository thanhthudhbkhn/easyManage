<?php
    session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (!isset($_SESSION["name"])) {
            header ("Location: login.php");
        } else {
            $now = time();
            if($now-$_SESSION["create"]>10*60) {
                session_unset();
                echo "Your session has expired!"
                . "<a href='login.php'> Login here</a>";
            } else{
                echo $_SESSION["name"]." is working.<br><br>";
            }
        }
        ?>
        <h2>List of employee</h2>
        <?php
        $conn=mysql_connect("localhost","root","");
        if (!$conn) {
            die("Connection failed: " . mysql_connect_error());
        }
        mysql_select_db("project1",$conn);
        $sql="select id,name,email from employee";
        $query=mysql_query($sql);
        if(!$query){
            die("Invalid query: ".mysql_error());
        } else{
            if (mysql_num_rows($query)>0){
                echo "<table><tr><th>ID</th><th>Name</th><th>Email</th></tr>";
                while($row = mysql_fetch_assoc($query)) {
                    echo "<tr><td>".$row["id"]."</td><td>".$row["name"]."</td><td>".$row["email"]."</td>";
                    echo "<td><a href=\"update.php?id=".$row['id']."\">Update Information</a></td>";
                    echo "<td><a href=\"delete.php?id=".$row['id']."\">Delete</a></td>";
                }
                echo"</table>";
            } else {
                echo "there are not any employee.<br>";
            }
        }
        
        ?>
        <form name="addOrOut">
            <input type="button" value="Add new employee" onclick="add()">
            <input type="button" value="Logout" onclick="logOut()">
        </form>
        <script>
            function logOut(){
                document.addOrOut.action = "logout.php";
                document.addOrOut.submit();
            }
            function add(){
                document.addOrOut.action = "add.php";
                document.addOrOut.submit();
            }
        </script>
    </body>
</html>
