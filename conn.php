<?php 
 
    $conn=new mysqli("localhost","root","","shopping");

    if($conn->connect_error){

        die("Connection Failed" .$conn->connect_error);
    }

?>