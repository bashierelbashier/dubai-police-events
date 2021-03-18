<?php

include "connect.php";


$query = "SELECT * FROM T_COORDINATORS WHERE EVENT_ID = " . $_POST['event_id'];
$result= mysqli_query($connect,$query);

$output = "";
$count = 1;

if (mysqli_num_rows($result)>0)
{
    while ($row=mysqli_fetch_array($result))
    {
        $event_id = $row['ID'];

        $output .= "<tr id= '".$event_id."' class= 'event-row' style= 'cursor:pointer;' align= 'center'>
            <td>".$count."</td>
            <td>".$row['NAME']."</td>
            <td>".$row['REFERENCE']."</td>
            <td>".$row['POSITION']."</td>
        </tr>";

        $count++;
    }
}
else{
    $output .= '<tr align="center"><td colspan="5"> لاتوجد بيانات </td></tr>';
}

echo $output;