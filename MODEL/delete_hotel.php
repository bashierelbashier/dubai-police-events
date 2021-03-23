<?php
include "connect.php";

$id = $_POST['id'];

$query = "DELETE FROM T_EVENT_HOTELS WHERE ID = ". $id;

if (mysqli_query($connect, $query))
{
    echo "done";
}