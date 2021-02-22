<?php
include "connect.php";
$query = "SELECT * FROM T_LAND_TYPES";
$result= mysqli_query($connect,$query);
$output = "";
while ($rowe=mysqli_fetch_array($result))
{
    $output .="<option value='".$rowe['TYPE_NO']."'>".$rowe['TYPE_NAME']."</option>";
}
echo $output;
?>