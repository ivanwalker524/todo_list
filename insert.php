<?php
    require_once "./config.php";
    $errors="";
    if(isset($_POST['submit'])){
        if(empty($_POST['task'])){
            $errors = "You must fill in the task";
            echo "<h1>$errors </h1>";
        }else{
            $task = $_POST['task'];
            $task_id= $_POST['task_id'];
            $sql=mysqli_query($db,"INSERT INTO tasks (task_id,task) values($task_id,'$task')
            ON DUPLICATE KEY UPDATE `task` = values(`task`) ");
            if($sql){
              header('location: index.php');
            }
        }
        }