<?php
session_start();
include "connect.php";
$name= $_POST['text'];
$id = $_POST['id'];


$modifier_id = $_SESSION['USER_NO'];


$query = "UPDATE T_CLASSIFICATIONS SET CLASS_NAME='".$name."', MODIFIER_ID=".$modifier_id.",DATE_MODIFIED=CURTIME()
WHERE CLASS_NO = ".$id;

if (mysqli_query($connect,$query))
{

    $query = "SELECT * FROM T_CLASSIFICATIONS";
    $res = mysqli_query($connect,$query);
    $output = '<table class="table table-bordered" style="font-size:large"><tr align="center" style="background-color:#e8e8e8">
                 <td  ><b># متسلسل</b></td>
                 <td width="70%" colspan="2"><b>التصنيف</b></td>
           </tr>';
    $count = 1;

    while($row = mysqli_fetch_array($res))
    {
        $output .='<tr align="center"><td>'.$count.'</td><td width="70%" >'.$row['CLASS_NAME'].'</td>
    <input hidden type="text" value="'.$row['CLASS_NAME'].'" id="c'.$row['CLASS_NO'].'"/>
    <td>
    <button class="btn btn-primary class-update" id="'.$row['CLASS_NO'].'"> <i class="fa fa-edit"></i> تعديل الإسم </button>
    <button class="btn btn-danger class-delete" id="'.$row['CLASS_NO'].'"> <i class="fa fa-remove"></i> حذف </button>
    </td>
    </tr>';
        $count = $count+1;
    }
    $output .="</table>";

    echo $output;
}

?>