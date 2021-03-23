<?php
include "connect.php";

$id = $_POST['id'];

$query = "DELETE FROM T_COORDINATORS WHERE ID = ". $id;

if (mysqli_query($connect, $query))
{
    echo "done";
}