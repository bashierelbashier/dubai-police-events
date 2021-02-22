<?php

include "connect.php";
$query = "";
if (isset($_POST['txt']) && $_POST['txt']!="")
{
    $query = "SELECT * FROM T_OWNERS WHERE OWNER_NAME LIKE '%".$_POST['txt']."%' OR 
    IDENTITY_NO LIKE '%".$_POST['txt']."%'";
}else
{
    $query = "SELECT * FROM T_OWNERS";
}
$ores = mysqli_query($connect,$query);
$count = 1;
$output = "<table class='table table-bordered'>";
if (mysqli_num_rows($ores)>0) {


    while ($orow = mysqli_fetch_array($ores)) {

        if ($orow['IDENTITY_TYPE']==1)
            $orow['IDENTITY_TYPE']=' رقم وطني ';
        else if($orow['IDENTITY_TYPE']==2)
            $orow['IDENTITY_TYPE']=' بطاقة قومية ';
        else if($orow['IDENTITY_TYPE']==3)
            $orow['IDENTITY_TYPE']=' جواز سفر ';
        else if($orow['IDENTITY_TYPE']==4)
            $orow['IDENTITY_TYPE']=' جواز سفر ';
        else if($orow['IDENTITY_TYPE']==0) {
            $orow['IDENTITY_TYPE'] = ' لايوجد ';
            $orow['IDENTITY_NO']='-------';
        }


        if ($orow['OWNER_TYPE']==1)
            $orow['OWNER_TYPE']=' فرد ';
        else if($orow['OWNER_TYPE']==2)
            $orow['OWNER_TYPE']=' مؤسسة ';

        $output .= "<tr class='owner-row' id='" . $orow['OWNER_NO'] . "' content='".$orow['OWNER_NAME']."' style='cursor: pointer;' align='center'>
                              <td width='15%'>" . $count++ . "</td>
                              <td width='45%'>" . $orow['OWNER_NAME'] . "</td>
                              <td width='40%'>" . $orow['OWNER_TYPE'] . "</td></tr>";
    }
    $output .= "</table>";

}else{
    $output = "<br/><br/><br/><br/> <br/><h1 align='center'> لاتوجد بيانات <i class='fa fa-frown-o'> </i>  </h1>";
}
echo $output;

?>