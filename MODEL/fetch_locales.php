<?php
include "connect.php";
$query = "SELECT * FROM T_LOCALES";
$result= mysqli_query($connect,$query);
$output = "";
while ($rowe=mysqli_fetch_array($result))
{
    $output .="<option value='".$rowe['LOCALE_NO']."'>".$rowe['LOCALE_NAME']."</option>";
}
echo $output;
?>