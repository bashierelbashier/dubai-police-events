<?php

include "connect.php";

$query = "SELECT * FROM T_USERS";

$result= mysqli_query($connect,$query);

$output = "<table class='table table-striped table-bordered' style='font-size:medium;'>
<tr class='fixed-top' align='center' style='background-color:dimgrey;color:white' >
<td>  متسلسل # </td>
<td> إسم المستخدم </td>
<td> الرقم التعريفي </td>
<td> درجة الصلاحية </td>
<td> نشط؟ </td>
</tr>";

$count = 1;

while ($row=mysqli_fetch_array($result))
{
    $privilege = '';
    if ($row['PRIVILEGE_NO']==1)
        $privilege=' كامل الصلاحيات (آدمن) ';
    if ($row['PRIVILEGE_NO']==2)
        $privilege=' مشرف أرشيف ';
    if ($row['PRIVILEGE_NO']==3)
        $privilege=' موظف أرشيف ';
    if ($row['PRIVILEGE_NO']==4)
        $privilege=' إستعلام وتقارير ';
    if ($row['PRIVILEGE_NO']==5)
        $privilege=' أمين أرشيف ';

    if ($row['ACTIVE']==true)
        $row['ACTIVE']='نعم';
    else
        $row['ACTIVE']='لا';




    $output .= "
        <tr class='user-row' id='".$row['USER_NO']."' style='cursor:pointer;' align='center'>
        <td>" . $count . "</td>
        <td>" . $row['FULL_NAME'] . "</td><td>" . $row['USER_NAME'] . "</td>
        <td>" . $privilege . "</td><td>" . $row['ACTIVE'] . "</td>
        </tr>";
    $count++;

}

$output .= "</table>";


echo $output;

?>