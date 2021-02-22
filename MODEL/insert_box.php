<?php

session_start();
include "connect.php";
$office = $_POST['office_no'];
$cupboard = $_POST['cupboard_no'];
$unit = $_POST['unit_no'];
$shelf = $_POST['shelf_no'];
$box = $_POST['box_no'];
$query = "SELECT MAX(BOX_ID) AS MAX FROM T_BOXES";
$res = mysqli_query($connect,$query);
$row = mysqli_fetch_array($res);
$max = $row['MAX']+1;
$creator = $_SESSION['USER_NO'];
$query = "INSERT INTO T_BOXES VALUES (".$max.",".$office.",
".$cupboard.",".$unit.",".$shelf."
,".$box.",CURTIME(),".$creator.",Null,Null)";
if (mysqli_query($connect,$query))
{

    $query = "SELECT * FROM T_BOXES";
    $res = mysqli_query($connect,$query);
    $output = '<table class="table table-bordered" style="font-size:large;" >
                        <tr align="center" style="background-color:#e8e8e8">
                            <td width="10%" ><b># متسلسل</b></td>
                            <td width="12%" ><b>رقم المكتب</b></td>
                            <td width="12%" ><b>رقم الدولاب</b></td>
                            <td width="12%" ><b>رقم الوحدة</b></td>
                            <td width="12%" ><b>رقم الرف</b></td>
                            <td width="12%" ><b>رقم الصندوق</b></td>
                            <td width="30%" ><b>*****</b></td>
                        </tr>';
    $count = 1;

    while($row = mysqli_fetch_array($res)) {
        $output .= '<tr align="center"><td>'.$count.'</td>
                                <td width="12%" >'.$row['OFFICE_NO'].'</td>
                                <td width="12%" >'.$row['CUPBOARD_NO'].'</td>
                                <td width="12%" >'.$row['UNIT_NO'].'</td>
                                <td width="12%" >'.$row['SHELF_NO'].'</td>
                                <td width="12%" >'.$row['BOX_NO'].'</td>
                                <td width="30%">
                                    <button class="btn hidden btn-primary box-update" id="'.$row['BOX_ID'].'"> <i class="fa fa-edit"></i> تعديل </button>
                                    <button class="btn btn-danger box-delete" id="'. $row['BOX_ID'].'"> <i class="fa fa-remove"></i> حذف </button>
                                </td>
                            </tr>';
        $count = $count+1;
    }
    $output .= '</table>';

    echo $output;

}

?>