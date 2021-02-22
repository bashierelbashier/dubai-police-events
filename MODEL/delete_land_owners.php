<?php
session_start();
include "connect.php";

$district = $_POST['district'];
$land = $_POST['land'];
$owner = $_POST['owner'];

$creator = $_SESSION['USER_NO'];
$query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO ='".$land."' AND DISTRICT_NO = ".$district." AND OWNER_NO =".$owner;
$output = '<table align="center" class="table table-bordered">
                                <tr align="center" style="background-color: #0c5460;color:white">
                                    <td> متسلسل # </td>
                                    <td> إسم المالك </td>
                                    <td> رقم الهاتف 1 </td>
                                    <td> رقم الهاتف 2 </td>
                                    <td> إثبات الشخصية </td>
                                    <td></td>
                                </tr>
                            ';

if(mysqli_query($connect,$query))
{
    $query = "SELECT * FROM T_LAND_OWNERS JOIN
              T_OWNERS USING (OWNER_NO) WHERE LAND_NO = '".$land."' AND DISTRICT_NO =".$district;
    $res = mysqli_query($connect,$query);
    $count = 1;
    while ($row=mysqli_fetch_array($res))

    {
        if ($row['IDENTITY_TYPE']==1)
            $row['IDENTITY_TYPE']='رقم وطني';
        else if ($row['IDENTITY_TYPE']==2)
            $row['IDENTITY_TYPE']='بطاقة قومية';
        else if ($row['IDENTITY_TYPE']==3)
            $row['IDENTITY_TYPE']='جواز سفر';

        $output .= '<tr align="center"><td>'.$count++.'</td><td>'.$row['OWNER_NAME'].'</td>
                    <td>'.$row['PHONE_NO1'].'</td><td>'.$row['PHONE_NO2'].'</td>
                    <td> '.$row['IDENTITY_NO'].'  ( '.$row['IDENTITY_TYPE'].' ) </td>
                    <td><button id="'.$row['OWNER_NO'].'" type="button" class="btn owner-remove btn-danger"> <i class="fa fa-remove"></i> حذف </button></td></tr>';
    }

    $output .= '</table>';
    echo $output;

}

?>