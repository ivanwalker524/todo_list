<?php
$db = mysqli_connect("localhost", "onlineutilities_todo", "todo", "onlineutilities_todo");
if (!$db) {
    echo "Database connected" . mysqli_connect_error();
}
