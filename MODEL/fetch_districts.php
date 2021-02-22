<?php
include "connect.php";
$output = "";
if (isset($_POST['locale_no']))
{
    $query = "SELECT * FROM T_DISTRICTS WHERE LOCALE_NO = ".$_POST['locale_no'];
    $result= mysqli_query($connect,$query);
    while ($rowe=mysqli_fetch_array($result))
    {
        $output .="<option value='".$rowe['DISTRICT_NO']."'>".$rowe['DISTRICT_NAME']."</option>";
    }
}else
{
    $query = "SELECT * FROM T_DISTRICTS";
    $result= mysqli_query($connect,$query);
    while ($rowe=mysqli_fetch_array($result))
    {
        $output .="<option value='".$rowe['DISTRICT_NO']."'>".$rowe['DISTRICT_NAME']."</option>";
    }
}

echo $output;

?>