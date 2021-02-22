<?php
include "connect.php";
$owner_no = $_POST['owner_no'];


$query = "DELETE FROM T_OWNERS WHERE OWNER_NO=".$owner_no;

if (mysqli_query($connect,$query))
{
    echo "done";
}
?>