<?php

session_start();
include "connect.php";
$creator = $_SESSION['USER_NO'];
$district = $_POST['district'];
$land = $_POST['land'];
if(isset($_POST['owner'])){


    $owner = $_POST['owner'];
    $query = "INSERT INTO T_LAND_OWNERS VALUES (" . $land . ",'" . $district . "'," . $owner . " , CURTIME() ," . $creator . ")";




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

    if (mysqli_query($connect, $query)) {
        $query = "SELECT * FROM T_LAND_OWNERS JOIN
              T_OWNERS USING (OWNER_NO) WHERE LAND_NO = '" . $land . "' AND DISTRICT_NO =" . $district;
        $res = mysqli_query($connect, $query);
        $count = 1;

        while ($row = mysqli_fetch_array($res)) {

            include "process_idtype.php";
            include "process_owner_type.php";

            $output .= '<tr align="center"><td>' . $count++ . '</td><td>' . $row['OWNER_NAME'] . '</td>
                    <td>' . $row['OWNER_TYPE']. '</td>
                    <td>' . $row['PHONE_NO1'] . '</td><td>' . $row['PHONE_NO2'] . '</td>
                    <td><button id="' . $row['OWNER_NO'] . '" type="button" class="btn owner-remove btn-danger"> <i class="fa fa-remove"></i> حذف </button></td></tr>';
        }

        $output .= '</table>';
        echo $output;

    }
}else if (isset($_POST['owners'])) {


    $owners = $_POST['owners'];

    $query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO = '".$land."' AND DISTRICT_NO =".$district;
    mysqli_query($connect,$query);
    foreach ($owners as $owner) {

        $query = "INSERT INTO T_LAND_OWNERS VALUES ('".$land."','".$district."',".$owner.", CURTIME() ,".$creator.")";
        mysqli_query($connect, $query);
        echo $query;

    }

}
else
{
    $query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO = '".$land."' AND DISTRICT_NO =".$district;
    mysqli_query($connect,$query);

}
?>