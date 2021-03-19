<?php
include "connect.php";
$id = $_POST['id'];
$query = "DELETE FROM T_CLASSIFICATIONS WHERE CLASS_NO=".$id;
$res = mysqli_query($connect,$query);

if ($res){
    $output = '<table class="table table-bordered" style="font-size:large"><tr align="center" style="background-color:#e8e8e8">
                 <td  ><b># متسلسل</b></td>
                 <td width="70%" colspan="2"><b>التصنيف</b></td>
           </tr>';
    $count = 1;
    $query = "SELECT * FROM T_CLASSIFICATIONS";
    $res = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($res))
    {
        $output .='<tr align="center"><td>'.$count.'</td><td width="70%" >'.$row['CLASS_NAME'].'</td>
    <input hidden type="text" value="'.$row['CLASS_NAME'].'" id="c'.$row['CLASS_NO'].'">
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
