<?php
include "connect.php";
$query = "SELECT * FROM T_CLASSIFICATIONS";
$result= mysqli_query($connect,$query);
$output = "";
while ($rowc=mysqli_fetch_array($result))
{
    $output .="<option value='".$rowc['CLASS_NO']."'>".$rowc['CLASS_NAME']."</option>";
}
echo $output;
?>