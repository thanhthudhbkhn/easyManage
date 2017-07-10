<?php
    session_start();
    session_unset();
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
        // put your code here
        if (!isset($_SESSION["name"])){ //neu xoa session thanh cong
            echo "Log out success.";
        }
        else echo $_SESSION["name"];
        ?>
    </body>
</html>
