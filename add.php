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
        }
        $name = $password = $email = "";
        $nameErr = $passwordErr = $emailErr = "";
        
        if (filter_input(INPUT_SERVER,"REQUEST_METHOD") == "POST"){
            //check name
            if(empty($_POST["name"])){ //khi khong co data
                $nameErr = "Name is required!";
            } else{
                $name = check_input(filter_input(INPUT_POST, "name"));
                $nameErr = "";
                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                    $nameErr = "Only letters and white space allowed";
                    $name = "";
                }
            }
            //check password
            if(empty($_POST["password"])){ //khi khong co data
                $passwordErr = "Password is required!";
            } else{
                $password = check_input(filter_input(INPUT_POST, "password"));
                $passwordErr = "";
            }
            //check email
            if (empty($_POST["email"])) {
                //$email = "";
            } else {
                $email = check_input($_POST["email"]);
                $emailErr = "";
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format"; 
                    $email = "";
                }
            }
            //sau khi lay xong name, pass va email thi ket noi voi db de insert
            if ((empty($nameErr))&&(empty($passwordErr))&&(empty($emailErr))){ //kiem tra co truong nao loi khong
                $conn=mysql_connect("localhost","root","","project1");
                if (!$conn) {
                    die("Connection failed: " . mysql_connect_error());
                }
                mysql_select_db("project1",$conn);
                $sql="INSERT INTO employee (name,password,email) VALUES ('$name','$password','$email')";
                $query=mysql_query($sql);
                if(!$query){
                    die("Invalid query: ".mysql_error());
                } else{
                    header("Location: work.php");
                }
                mysql_close($conn);
            }
        }
        
        function check_input($data){
            $data = trim($data); //loai bo dau cach
            $data = stripslashes($data); //loai bo dau /
            $data = htmlspecialchars($data); //loai bo tag
            $data = mysql_real_escape_string($data);
            return $data;
        }
        ?>
        <h2>Add a new employee</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            Name: <input type="text" name="name"> *
            <span class="error"> <?php echo $nameErr; ?></span>
            <br><br>
            Password: <input type="password" name="password"> *
            <span class="error"> <?php echo $passwordErr; ?></span>
            <br><br>
            Email: <input type="text" name="email"> 
            <span class="error"> <?php echo $emailErr; ?></span>
            <br><br>
            <input type="submit" name="submit" value="Add">
        </form>
        
    </body>
</html>
