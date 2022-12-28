<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List App</title>
    <style>
        <?php require "./style.css" ?>
    </style>
</head>
<?php
    include "./config.php";
    $mytext="";
    $id=0;
    //edit part
    if(isset($_GET['ed_task'])){
    $ed_id=$_GET['ed_task'];
    $data= mysqli_query($db,"SELECT * FROM tasks WHERE task_id ='$ed_id'");
    $row=$data->fetch_assoc();
    $mytext=$row['task'];
    $id=$row['task_id'];
    }
    //delete part
   else if(isset($_GET['del_task'])){
    $del_task= $_GET['del_task'];

    $db->query("DELETE FROM tasks WHERE task_id='$del_task'");
    header('location: index.php');
    ?>
<?php
   }
?>
<body>
    <div class="container max-width auto">
        <div class="wd flex">
            <div class="heading">
                <h1>Todo list with php and mysqli</h1>
            </div>
            <form action="./insert.php" method="post">
                <?php if(isset($errors)){?>
                    <h1 style="color: red;"><?php echo $errors; ?></h1>
            <?php } ?>
                <input type="text" name="task" value="<?php echo $mytext; ?>">
                <input type="hidden" name="task_id" value="<?php echo $id ?>">
                <input type="submit" value="Add" name="submit"></input>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Tasks</th>
                        <th style="width:60px;">Edit</th>
                        <th style="width: 60px;">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include_once "./config.php";
                        $tasks = mysqli_query($db,"SELECT * FROM tasks");

                        $i = 1; while ($row = mysqli_fetch_array($tasks)){ ?>
                            <tr>
                                <td> <?php echo $i; ?></td>
                                <td class="task"> <?php echo $row['task']; ?></td>
                                <td class="edit">
                                    <a href="./?ed_task=<?php echo $row['task_id'] ?>">edit</a>
                                </td>
                                <td class="delete">
                                    <a href="./?del_task=<?php echo $row['task_id'] ?>">x</a>
                                </td>
                            </tr>
                        <?php $i++;} ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>