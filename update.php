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
        <?php //kiem tra session
        if (!isset($_SESSION["name"])) {
                header ("Location: login.php");
        } else {
            if (isset($_GET['id'])){ 
                $id = filter_input(INPUT_GET, 'id');
                echo $_SESSION["name"]." is updating for employee has id=$id";
            }
        }
        $name = $password = "";
        $nameErr = $passwordErr = "";
        ?>
        
        <form method="post">
            New name: <input type="text" name="name">
            <span class="error"> <?php echo $nameErr; ?></span>
            <br><br>
            New password: <input type="password" name="password"> 
            <span class="error"> <?php echo $passwordErr; ?></span>
            <br><br>
            <input type="submit" name="submit" value="Update">
        </form>
        
        <?php //lay du lieu tu form va update vao database
        if (filter_input(INPUT_SERVER,"REQUEST_METHOD") == "POST"){
            if( filter_input(INPUT_POST, "name")==="" ){ //khi khong co data
                $nameErr = "Name is required!";
            } else{
                $name = check_input(filter_input(INPUT_POST, "name"));
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                    $nameErr = "Only letters and white space allowed";
                    $name = "";
                }
            }
            echo "ten la".$name.".";
            if(empty($_POST["password"])){ //khi khong co data
                $passwordErr = "Password is required!";
            } else{
                $password = check_input(filter_input(INPUT_POST, "password"));
            }
            if ((!empty($name))&&(!empty($password))){ //kiem tra xau rong
                $conn=mysql_connect("localhost","root","");
                if (!$conn) {
                    die("Connection failed: " . mysql_connect_error());
                }
                mysql_select_db("project1",$conn);

                $sql = "UPDATE employee SET name='$name',password='$password' WHERE id='$id'";
                $query = mysql_query($sql);
                mysql_close($conn);
                if(!$query){
                    die("Invalid query: ".mysql_error());
                } else header("Location: work.php");
            } else {
                echo "vui long nhap du lieu.";
            }
        }
        
        ?>
        <?php //cac ham tu viet
        function check_input($data){
            $data = trim($data); //loai bo dau cach
            $data = stripslashes($data); //loai bo dau /
            $data = htmlspecialchars($data); //loai bo tag
            $data = mysql_real_escape_string($data);
            return $data;
        }
        ?>
    </body>
</html>
