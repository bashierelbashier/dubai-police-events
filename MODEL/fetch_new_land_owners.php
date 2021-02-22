<?php
include "connect.php";
$query = "";


$output = '<table align="center" class="table table-bordered">
                                <tr align="center" style="background-color: #0c5460;color:white">
                                    <td> متسلسل # </td>
                                    <td> إسم المالك </td>
                                    <td> نوع المالك </td>
                                    <td> رقم الهاتف 1 </td>
                                    <td> رقم الهاتف 2 </td>
                                    <td></td>
                                </tr>
                            ';




if(isset($_POST['owners']))
{
    $owners = $_POST['owners'];
    $query = "SELECT * FROM T_OWNERS WHERE ";
    $count = 0;
    $last = end($owners);
    foreach ($owners as $owner)
    {
        if ($owner==$last)
        {
            $query .=" OWNER_NO = ".$owner;
        }else
        {
            $query .=" OWNER_NO = ".$owner." OR ";
        }

        $count++;
    }

    $count = 1;

    if ($res = mysqli_query($connect, $query))
    {
        while ($row = mysqli_fetch_array($res)) {

            include "process_idtype.php";
            include "process_owner_type.php";

            $output .= '<tr align="center"><td>' . $count++ . '</td><td>' . $row['OWNER_NAME'] . '</td>
                    <td>' . $row['OWNER_TYPE']. '</td>
                    <td>' . $row['PHONE_NO1'] . '</td><td>' . $row['PHONE_NO2'] . '</td>
                    <td><button id="' . $row['OWNER_NO'] . '" type="button" class="btn owner-remove btn-danger"> <i class="fa fa-remove"></i> حذف </button></td></tr>';
        }
    }


}

$output .= '</table>';


echo $output;


?>