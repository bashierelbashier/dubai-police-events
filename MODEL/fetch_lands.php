<?php

include "connect.php";
$limit = $_POST['limit'];
$start = $_POST['start'];
$output = '<br/>';

if (isset($_POST['txt']) && $_POST['txt']!="" && isset($_POST['district']) && $_POST['district']!=0)
{
    $sql = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
 JOIN T_LOCALES USING (LOCALE_NO)
 JOIN T_CLASSIFICATIONS USING (CLASS_NO) WHERE LAND_NO LIKE '%".$_POST['txt']."%' AND DISTRICT_NO = ".$_POST['district'];

}
else if (isset($_POST['district']) && $_POST['district']!=0)
{
    $sql = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
 JOIN T_LOCALES USING (LOCALE_NO)
 JOIN T_CLASSIFICATIONS USING (CLASS_NO) WHERE DISTRICT_NO = ".$_POST['district'];
}
else if (isset($_POST['txt']) && $_POST['txt']!="")
{
    $sql = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
 JOIN T_LOCALES USING (LOCALE_NO)
 JOIN T_CLASSIFICATIONS USING (CLASS_NO) WHERE LAND_NO LIKE '%".$_POST['txt']."%'";
}
else
{
    $sql = "SELECT * FROM T_LANDS JOIN T_DISTRICTS USING (DISTRICT_NO,LOCALE_NO)
 JOIN T_LOCALES USING (LOCALE_NO)
 JOIN T_CLASSIFICATIONS USING (CLASS_NO) ";
}

$sql .=" LIMIT ".$start.",".$limit;

$res = mysqli_query($connect,$sql);

if (mysqli_num_rows($res)>0)
{
    while($row = mysqli_fetch_array($res))
    {
        if ($row['AREA_UNIT']==1)
            $row['AREA_UNIT']=' متر ';
        else
            $row['AREA_UNIT']=' فدان ';

        $output .= '<a href="edit_land.php?LAND_NO='.$row['LAND_NO'].'&DISTRICT_NO='.$row['DISTRICT_NO'].'" id="'.$row['LAND_NO'].'" ><div dir="rtl" style="cursor: pointer ;box-shadow: 1px 1px 1px 1px grey ;border-style:solid;margin-bottom:2%;margin-right:5%;background-color:white;border-radius: 0px;border-width: 1px;border-color: lightgray" class="col-xs-5 pull-right">
			<h5 style="background-color:lightgrey;color:black" align="center"> رقم القطعة : '.$row['LAND_NO'].'</h5>
			<h5 class="col-xs-12">  المحلية :  '.$row['LOCALE_NAME'].'</h5>
			<h5 class="col-xs-12"> المربوع : '.$row['DISTRICT_NAME']. '</h5>
			<h5 class="col-xs-5">    المساحة : '.$row['AREA'].' '.$row['AREA_UNIT'].'</h5>
			<h5 class="col-xs-7 pull-right" > التصنيف : '.$row['CLASS_NAME'].' </h5></div></a>';
    }
    echo $output;
}
else
{
    echo "<br/><br/><br/><br/> <br/><h1> ليس هناك أي بيانات أنقر إنشاء  <i class='fa fa-hand-o-up'></i>  لإضافة جديد </h1>";
}



?>