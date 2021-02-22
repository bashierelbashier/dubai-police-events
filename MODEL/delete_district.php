<?php
include "connect.php";
$id = $_POST['id'];
$query = "DELETE FROM T_DISTRICTS WHERE DISTRICT_NO=".$id;
$res = mysqli_query($connect,$query);

if ($res){
    $output = '<table class="table table-bordered" style="font-size:large"><tr align="center" style="background-color:#e8e8e8">
                 <td  ><b># متسلسل</b></td>
                 <td width="35"><b>إسم المحلية</b></td>
                 <td width="35%" colspan="2"><b>إسم المربوع</b></td>
           </tr>';
    $count = 1;
    $query = "SELECT * FROM T_DISTRICTS JOIN T_LOCALES USING (LOCALE_NO)";
    $res = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($res))
    {
        $output .='<tr align="center">
<td>'.$count.'</td>
<td width="35%" >'.$row['LOCALE_NAME'].'</td>
<td width="35%" >'.$row['DISTRICT_NAME'].'</td>
    <input hidden type="text" value="'.$row['LOCALE_NO'].'" id="dl'.$row['DISTRICT_NO'].'"/>
    <input hidden type="text" value="'.$row['DISTRICT_NAME'].'" id="d'.$row['DISTRICT_NO'].'"/>
    <td>
    <button class="btn btn-primary district-update" id="'.$row['DISTRICT_NO'].'"> <i class="fa fa-edit"></i> تعديل الإسم  </button>
    <button class="btn btn-danger district-delete" id="'.$row['DISTRICT_NO'].'"> <i class="fa fa-remove"></i> حذف </button>
    </td>
    </tr>';
        $count = $count+1;
    }
    $output .="</table>";

    echo $output;
}

?>
