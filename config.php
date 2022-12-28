<?php
    $db=mysqli_connect("localhost","root","","todo");
    if(!$db){
        echo "Database connected". mysqli_connect_error();
    }