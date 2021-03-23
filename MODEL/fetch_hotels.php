<?php

include "connect.php";


$query = "SELECT * FROM T_EVENT_HOTELS WHERE EVENT_ID = " . $_POST['event_id'];
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
            <td>".$row['HOTEL_NAME']."</td>
            <td>".$row['HOTEL_LOCATION']."</td>
            <td>".$row['HOTEL_COORDINATES']."</td>
            <td class='text-center' style='width: 10%;'>
                <button type='button' class='btn btn-primary edit-hotel' data-id='".$row['ID']."' data-name='".$row['HOTEL_NAME']."' data-location='".$row['HOTEL_LOCATION']."' data-coordinates='".$row['HOTEL_COORDINATES']."'  data-toggle='modal'data-target='#HotelModal' title='تعديل'><i class='fa fa-edit'></i></button>
                <button type='button' class='btn btn-danger delete-hotel' data-id='".$row['ID']."' title='حذف'><i class='fa fa-times'></i></button>
            </td>
        </tr>";

        $count++;
    }
}
else{
    $output .= '<tr align="center"><td colspan="5"> لاتوجد بيانات </td></tr>';
}

echo $output;