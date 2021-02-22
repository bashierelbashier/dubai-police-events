<?php
include "connect.php";
$id = $_POST['id'];
$query = "DELETE FROM T_LOCALES WHERE LOCALE_NO=".$id;
$res = mysqli_query($connect,$query);

if ($res){
    $output = '<table class="table table-bordered" style="font-size:large"><tr align="center" style="background-color:#e8e8e8">
                 <td  ><b># متسلسل</b></td>
                 <td width="70%" colspan="2"><b>إسم المحلية</b></td>
           </tr>';
    $count = 1;
    $query = "SELECT * FROM T_LOCALES";
    $res = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($res))
    {
        $output .='<tr align="center"><td>'.$count.'</td><td width="70%" >'.$row['LOCALE_NAME'].'</td>
    <td><input hidden type="text" value="'.$row['LOCALE_NAME'].'" id="l'.$row['LOCALE_NO'].'"/>
    <button class="btn btn-primary locale-update" id="'.$row['LOCALE_NO'].'"> <i class="fa fa-edit"></i> تعديل الإسم </button>
    <button class="btn btn-danger locale-delete" id="'.$row['LOCALE_NO'].'"> <i class="fa fa-remove"></i> حذف </button>
    </td></tr>';
        $count = $count+1;
    }
    $output .="</table>";

    echo $output;
}

?>
