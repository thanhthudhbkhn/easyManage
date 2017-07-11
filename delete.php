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
        // put your code here
        $conn=mysql_connect("localhost","root","");
        if (!$conn) {
            die("Connection failed: " . mysql_connect_error());
        }
        mysql_select_db("project1",$conn);
        $id = filter_input(INPUT_GET, 'id');
        $sql = "DELETE from employee WHERE id='$id'";
        $query = mysql_query($sql);
        if(!$query){
            die("Invalid query: ".mysql_error());
        }
        mysql_close($conn);
        header("Location: work.php");
        ?>
    </body>
</html>
