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

        $output .= "<tr id= '".$event_id."' class= 'coordinator-row' style= 'cursor:pointer;' align= 'center'>
        <td>".$count."</td>
        <td>".$row['NAME']."</td>
        <td>".$row['REFERENCE']."</td>
        <td>".$row['POSITION']."</td>
        <td class='text-center' style='width: 10%;'>
            <button type='button' class='btn btn-primary edit-coordinator' data-id='".$row['ID']."' data-name='".$row['NAME']."' data-reference='".$row['REFERENCE']."' data-position='".$row['POSITION']."'  data-toggle='modal'data-target='#CoordinationModal' title='تعديل'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-danger delete-coordinator' data-id='".$row['ID']."' title='حذف'><i class='fa fa-times'></i></button>
        </td>
        </tr>";

        $count++;
    }
}
else{
    $output .= '<tr align="center"><td colspan="5"> لاتوجد بيانات </td></tr>';
}

echo $output;