<?php

include "connect.php";

$query = "";

if (isset($_POST['txt']) && $_POST['txt']!="" && isset($_POST['district']) && $_POST['district']!="") {
    $query = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
    JOIN T_LOCALES USING (LOCALE_NO) 
    WHERE LAND_NO LIKE '%".$_POST['txt']."%' AND DISTRICT_NO =".$_POST['district'];
}else if (isset($_POST['txt']) && $_POST['txt']!="")
{
    $query = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
    JOIN T_LOCALES USING (LOCALE_NO)
    WHERE LAND_NO LIKE '%".$_POST['txt']."%'";

}else if (isset($_POST['district']) && $_POST['district']!="") {
    $query = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
    JOIN T_LOCALES USING (LOCALE_NO) WHERE DISTRICT_NO = ".$_POST['district'];
}else{

    $query = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
    JOIN T_LOCALES USING (LOCALE_NO) ";
}

$res = mysqli_query($connect,$query);
$count = 1;
$output = '
                        <table align="center" class="table table-bordered">
                            <tr align="center" style="background-color: #0c5460;color:white">
                                <td> متسلسل # </td>
                                <td> إسم المحلية </td>
                                <td> إسم المربوع </td>
                                <td> رقم قطعة الأرض </td>
                            </tr>
                        ';

while ($row=mysqli_fetch_array($res))
{
        $output .= '<tr align="center" id="land_no='.$row['LAND_NO'].'&district_no='.$row['DISTRICT_NO'].'" class="land-row"><td>'.$count++.'</td>
                    <td>'.$row['LOCALE_NAME'].'</td>
                    <td>'.$row['DISTRICT_NAME'].'</td>
                    <td>'.$row['LAND_NO'].'</td></tr>';
}

$output .='</table>';
echo $output;
