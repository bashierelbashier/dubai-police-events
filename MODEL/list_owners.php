<?php

include "connect.php";
$limit = $_POST['limit'];
$start = $_POST['start'];

$output = '<br/>';

if (isset($_POST['txt']) && $_POST['txt']!="")
{
    $sql = "SELECT * FROM T_OWNERS
  WHERE OWNER_NAME LIKE '%".$_POST['txt']."%' ";
}
else
{
    $sql = "SELECT * FROM T_OWNERS ";
}

$sql .=" LIMIT ".$start.",".$limit;

$res = mysqli_query($connect,$sql);

if (mysqli_num_rows($res)>0)
{
    while($row = mysqli_fetch_array($res))
    {

        include "process_idtype.php";

        $output .= '<a href="edit_owner.php?owner_no='.$row['OWNER_NO'].'" id="'.$row['OWNER_NO'].'" ><div dir="rtl" style="cursor: pointer ;box-shadow: 1px 1px 1px 1px grey ;border-style:solid;margin-bottom:2%;margin-right:5%;background-color:white;border-radius: 0px;border-width: 1px;border-color: lightgray" class="col-xs-5 pull-right">
			<h5 class="col-xs-12">  إلإسم :  '.$row['OWNER_NAME'].'</h5>
			<h5 class="col-xs-12"> الهاتف 1 : '.$row['PHONE_NO1']. '</h5>
			<h5 class="col-xs-12"> الهاتف 2 : '.$row['PHONE_NO2']. '</h5>
			<h5 class="col-xs-6" >  الرقم : '.$row['IDENTITY_NO'].' </h5>
			<h5 class="col-xs-6 pull-right"> إثبات الشخصية : '.$row['IDENTITY_TYPE'].'</h5></div></a>';
    }
    echo $output;
}
else
{
    echo "<br/><br/><br/><br/> <br/><h1> ليس هناك أي بيانات أنقر إنشاء  <i class='fa fa-hand-o-up'></i>  لإضافة جديد </h1>";
}


?>