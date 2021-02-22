<?php

session_start();
include "connect.php";

$land_no = $_POST['land_no'];
$give_type = $_POST['give_type'];
$sec_land_no = $_POST['sec_land_no'];
$district_no = $_POST['district_no'];
$trans_no = $_POST['trans_no'];
$trans_date = $_POST['trans_date'];
$first_party = $_POST['first_party'];
$sec_party = $_POST['sec_party'];
$m_or_y = $_POST['m_or_y'];
$period = $_POST['period'];
$renewal_term = $_POST['renewal_term'];
$area = $_POST['area'];
$behalf_name = $_POST['behalf_name'];
$behalf_phone = $_POST['behalf_phone'];
$id_type = $_POST['id_type'];
$id_no = $_POST['id_no'];

$creator = $_SESSION['USER_NO'];


$msql = "SELECT MAX(ID) AS MAX FROM T_TRANSACTION";
$mres = mysqli_query($connect,$msql);
$mrow = mysqli_fetch_array($mres);
$id = $mrow['MAX'];
$id += 1;

if ($trans_no==1)
{


        $query = "INSERT INTO T_LAND_OWNERS VALUES ('".$land_no."',
        '".$district_no."',".$first_party.",CURTIME(),".$creator.")";
        mysqli_query($connect,$query);


        $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
        '".$land_no."',".$district_no.",NULL,".$trans_no."
        ,'".$trans_date."',Null,".$period.",
        ".$m_or_y.",Null,".$first_party.",
        Null,'".$behalf_name."',".$id_type.",
        '".$id_no."','".$behalf_phone."',
        CURTIME(),".$creator.",Null,Null)";

}else if($trans_no==2)
{
    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'".$trans_date."',".$renewal_term.",".$period.",
".$m_or_y.",Null,Null,
Null,'".$behalf_name."',".$id_type.",
'".$id_no."','".$behalf_phone."',
CURTIME(),".$creator.",Null,Null)";

}
else if($trans_no==3)
{



        if ($give_type==1)
        {
            $query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO = '".$land_no."' AND
            DISTRICT_NO = ".$district_no." AND OWNER_NO = ".$first_party;
            mysqli_query($connect,$query);
        }

    $query = "INSERT INTO T_LAND_OWNERS VALUES ('".$land_no."',
    '".$district_no."',".$sec_party.",CURTIME(),".$creator.")";

    mysqli_query($connect,$query);

    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
    '".$land_no."',".$district_no.",NULL,".$trans_no."
    ,'".$trans_date."',Null,Null,
    Null,".$give_type.",".$first_party.",
    ".$sec_party.",'".$behalf_name."',".$id_type.",
    '".$id_no."','".$behalf_phone."',
    CURTIME(),".$creator.",Null,Null)";

}
else if($trans_no==4)
{

    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'" . $trans_date . "',Null,Null,
Null,Null,Null,
Null,'" . $behalf_name . "'," . $id_type . ",
'" . $id_no . "','" . $behalf_phone . "',
CURTIME()," . $creator . ",Null,Null)";

}else if($trans_no==5) {

    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'" . $trans_date . "',Null,Null,
Null,Null,Null,
Null,'" . $behalf_name . "'," . $id_type . ",
'" . $id_no . "','" . $behalf_phone . "',
CURTIME()," . $creator . ",Null,Null)";

}
else if($trans_no==6)
{


    $query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO = '".$land_no."' AND
        DISTRICT_NO = ".$district_no." AND OWNER_NO = ".$first_party;
    mysqli_query($connect,$query);

    $query = "UPDATE T_LANDS SET  AREA = AREA-".$area."
    WHERE LAND_NO = '".$land_no."' AND DISTRICT_NO = ".$district_no;
    mysqli_query($connect,$query);

    $query = "SELECT * FROM T_LANDS WHERE LAND_NO='".$land_no."' AND DISTRICT_NO =".$district_no;
    $result = mysqli_query($connect,$query);
    $row = mysqli_fetch_array($result);

    $query = "INSERT INTO T_LANDS (LOCALE_NO,DISTRICT_NO,LAND_NO,AREA,AREA_UNIT,STATUS,
    TYPE_NO,CLASS_NO,DATE_CREATED,CREATOR_ID) VALUES (".$row['LOCALE_NO'].",".$row['DISTRICT_NO'].",
    '".$sec_land_no."',".$area.",".$row['AREA_UNIT'].",0,".$row['TYPE_NO'].",".$row['CLASS_NO'].",
    CURTIME(),".$creator.")";

    mysqli_query($connect,$query);

    $query = "INSERT INTO T_LAND_OWNERS VALUES ('".$sec_land_no."',
    '".$district_no."',".$first_party.",CURTIME(),".$creator.")";
    mysqli_query($connect,$query);

    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
    '".$land_no."',".$district_no.",'".$sec_land_no."',".$trans_no."
    ,'".$trans_date."',Null,Null,
    Null,".$area.",".$first_party.",
    Null,'".$behalf_name."',".$id_type.",
    '".$id_no."','".$behalf_phone."',
    CURTIME(),".$creator.",Null,Null)";

}
else if($trans_no==7)
{
    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'".$trans_date."',Null,Null,
Null,".$area.",Null,
Null,'".$behalf_name."',".$id_type.",
'".$id_no."','".$behalf_phone."',
CURTIME(),".$creator.",Null,Null)";

}
else if($trans_no==8)
{

    $query = "UPDATE T_LANDS SET  STATUS = 1
WHERE LAND_NO = '".$land_no."' AND DISTRICT_NO = ".$district_no;
    mysqli_query($connect,$query);


    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'".$trans_date."',Null,Null,
Null,".$area.",Null,
Null,'".$behalf_name."',".$id_type.",
'".$id_no."','".$behalf_phone."',
CURTIME(),".$creator.",Null,Null)";

}
else if($trans_no==9)
{
    $query = "UPDATE T_LANDS SET  AREA = AREA+".$area."
    WHERE LAND_NO = '".$land_no."' AND DISTRICT_NO = ".$district_no;
    mysqli_query($connect,$query);


    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'".$trans_date."',Null,Null,
Null,".$area.",Null,
Null,'".$behalf_name."',".$id_type.",
'".$id_no."','".$behalf_phone."',
CURTIME(),".$creator.",Null,Null)";

}else if($trans_no==10)
{


    $query = "UPDATE T_LANDS SET  STATUS = 2
    WHERE LAND_NO = '".$land_no."' AND DISTRICT_NO = ".$district_no;
    mysqli_query($connect,$query);

    $query = "SELECT * FROM T_LANDS WHERE LAND_NO='".$land_no."' AND DISTRICT_NO =".$district_no;
    $result = mysqli_query($connect,$query);
    $row = mysqli_fetch_array($result);

    $query = "UPDATE T_LANDS SET  AREA = AREA+".$row['AREA']."
    WHERE LAND_NO = '".$sec_land_no."' AND DISTRICT_NO = ".$district_no;
    mysqli_query($connect,$query);



    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
    '".$land_no."',".$district_no.",'".$sec_land_no."',".$trans_no."
    ,'".$trans_date."',Null,Null,
    Null,".$row['AREA'].",Null,
    Null,'".$behalf_name."',".$id_type.",
    '".$id_no."','".$behalf_phone."',
    CURTIME(),".$creator.",Null,Null)";

}else if($trans_no==11)
{

    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'".$trans_date."',Null,Null,
Null,Null,Null,
Null,'".$behalf_name."',".$id_type.",
'".$id_no."','".$behalf_phone."',
CURTIME(),".$creator.",Null,Null)";

}else if($trans_no==12)
{
    $query = "UPDATE T_LANDS SET STATUS = 3
    WHERE LAND_NO = '".$land_no."' AND DISTRICT_NO = ".$district_no;
    mysqli_query($connect,$query);


    $query = "INSERT INTO T_TRANSACTION VALUES (".$id.",
'".$land_no."',".$district_no.",NULL,".$trans_no."
,'".$trans_date."',Null,Null,
Null,Null,Null,
Null,'".$behalf_name."',".$id_type.",
'".$id_no."','".$behalf_phone."',
CURTIME(),".$creator.",Null,Null)";

}

echo $query;

if (mysqli_query($connect,$query))
{
echo "done";
}



?>