<?php

include "connect.php";
$query = "SELECT * FROM T_OWNERS";
$result= mysqli_query($connect,$query);
$output = "";

while ($rowe=mysqli_fetch_array($result))
{
    $output .="<option value='".$rowe['OWNER_NO']."'>".$rowe['OWNER_NAME']." </option>";
}

echo $output;

?>