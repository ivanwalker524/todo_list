<?php
include "./config.php";
$errors = "";
if (isset($_POST['submit'])) {
    if (empty($_POST['task'])) {
        $errors = "The input is blank! try to add some items";
    } else {
        $task = $_POST['task'];
        $task_id = $_POST['task_id'];
        $current_time = date('H:i:s');
        $check = $db->query("SELECT * FROM tasks where task = '$task'") or die($db->error);
        if ($check->num_rows != 0) {
            $item = $check->fetch_assoc();
            $item_sub = $item['task'];
            $errors= $item_sub." is already submitted!";
        } else {
            $sql = mysqli_query($db, "INSERT INTO tasks (task_id,task,time) values($task_id,'$task','$current_time')
            ON DUPLICATE KEY UPDATE `task` = values(`task`) ");
            if ($sql) {
                header('location: index.php');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do List App</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <style>
        <?php require "./style.css" ?>
    </style>
</head>
<?php
$mytext = "";
$id = 0;
//edit part
if (isset($_GET['ed_task'])) {
    $ed_id = $_GET['ed_task'];
    $data = mysqli_query($db, "SELECT * FROM tasks WHERE task_id ='$ed_id'");
    $row = $data->fetch_assoc();
    $mytext = $row['task'];
    $id = $row['task_id'];
}
//delete part
else if (isset($_GET['del_task'])) {
    $del_task = $_GET['del_task'];

    $db->query("DELETE FROM tasks WHERE task_id='$del_task'");
    // header('location: index.php');
    // echo '<script>alert("Deleted successfully!")</script>';
    $del=$db->query("SELECT * FROM tasks WHERE task_id = '$del_task'") or die($db->error);
    $item = $del->fetch_assoc();
    $errors = "Item on id $del_task deleted successfully!";
}
?>

<body>
    <div class="padding">
        <div class="alert-cont">
            <p class="alert"><?php echo $errors ?></p>
        </div>
        <div class="container max-width auto">
            <div class="wd flex">
                <div class="heading">
                    <h1>To-do App</h1>
                </div>
                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    <input type="text" name="task" placeholder="Start creating your list" value="<?php echo $mytext; ?>">
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
                        // set current time

                        $tasks = mysqli_query($db, "SELECT * FROM tasks");

                        $i = 1;
                        while ($row = mysqli_fetch_array($tasks)) { 
                            $data=$row['task']; ?>
                            <tr>
                                <td> <?php echo $i; ?></td>
                                <td class="task"> <?=$data?><span class="time"><?=$row['time']?></span></td>
                                <td class="edit">
                                    <a href="./?ed_task=<?php echo $row['task_id'] ?>">edit</a>
                                </td>
                                <td class="delete" onclick="alert();">
                                    <a href="./?del_task=<?= $row['task_id'] ?>">x</a>
                                </td>
                            </tr>
                        <?php $i++;
                        } ?>
                    </tbody>
                </table>
                <div class="save">
                    <button>Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function alert(){
            var alert = confirm("Are you sure?\nYou want to delete!");
            if(alert == false){
                event.preventDefault();
            }
        }
    </script>
</body>

</html>