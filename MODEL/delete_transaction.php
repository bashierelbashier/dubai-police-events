<?php

session_start();
include "connect.php";

$trans_id = $_POST['trans_id'];



$tsql = "SELECT *,T_TRANSACTION.AREA AS T_AREA FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO) JOIN T_DISTRICTS USING (LOCALE_NO,DISTRICT_NO) 
JOIN T_LOCALES USING (LOCALE_NO) JOIN T_CLASSIFICATIONS USING (CLASS_NO) JOIN T_LAND_TYPES USING (TYPE_NO) WHERE ID = ".$trans_id;
$tres = mysqli_query($connect,$tsql);
$trow = mysqli_fetch_array($tres);


$msql = "SELECT MAX(TRANS_DATE) AS MAX FROM T_TRANSACTION WHERE LAND_NO='".$trow['LAND_NO']."'
AND DISTRICT_NO = ".$_POST['DISTRICT_NO']." AND (TRANSACTION_NO = 1 OR TRANSACTION_NO = 3)";
$mres = mysqli_query($connect,$msql);
$mrow = mysqli_fetch_array($mres);

$creator = $_SESSION['USER_NO'];

if ($trow['TRANSACTION_NO']==1)
{
    if ($trans_date==$mrow['MAX'])
    {
        $query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO = '".$trow['LAND_NO']."' AND
        DISTRICT_NO = ".$trow['DISTRICT_NO']." AND OWNER_NO =  ".$trow['FIRST_PARTY'];
        mysqli_query($connect,$query);
    }

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}else if($trow['TRANSACTION_NO']==2)
{

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}
else if($trow['TRANSACTION_NO']==3)
{

    if ($trans_date==$mrow['MAX'])
    {

        $query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO = '".$trow['LAND_NO']."' AND
        DISTRICT_NO = ".$trow['DISTRICT_NO']." AND OWNER_NO = ".$trow['SEC_PARTY'];
        mysqli_query($connect,$query);

        $query = "INSERT INTO T_LAND_OWNERS VALUES ('".$trow['LAND_NO']."',
        '".$trow['DISTRICT_NO']."',".$trow['FIRST_PARTY'].",CURTIME(),".$creator.")";
        mysqli_query($connect,$query);

    }

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}
else if($trow['TRANSACTION_NO']==4)
{

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}else if($trow['TRANSACTION_NO']==5) {

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}
else if($trow['TRANSACTION_NO']==6)
{


    $query = "DELETE FROM T_LAND_OWNERS WHERE LAND_NO = '".$trow['SEC_LAND_NO']."' AND
    DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);
    
    $query = "UPDATE T_LANDS SET  AREA = AREA+".$trow['T_AREA']."
    WHERE LAND_NO = '".$trow['LAND_NO']."' AND DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);

    $query = "DELETE FROM T_TRANSACTION WHERE LAND_NO = '".$trow['SEC_LAND_NO']."' AND
    DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);

    $query = "DELETE FROM T_DOCS WHERE LAND_NO = '".$trow['SEC_LAND_NO']."' AND
    DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);

    $query = "DELETE FROM T_LANDS WHERE LAND_NO = '".$trow['SEC_LAND_NO']."' AND
    DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);

    $query = "INSERT INTO T_LAND_OWNERS VALUES ('".$trow['LAND_NO']."',
    '".$trow['DISTRICT_NO']."',".$trow['FIRST_PARTY'].",CURTIME(),".$creator.")";
    mysqli_query($connect,$query);


    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}
else if($trow['TRANSACTION_NO']==7)
{
    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;
}
else if($trow['TRANSACTION_NO']==8)
{

    $query = "UPDATE T_LANDS SET  STATUS = 0
    WHERE LAND_NO = '".$trow['LAND_NO']."' AND DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}
else if($trow['TRANSACTION_NO']==9)
{

    $query = "UPDATE T_LANDS SET  AREA = AREA-".$trow['T_AREA']."
    WHERE LAND_NO = '".$trow['LAND_NO']."' AND DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;
}
else if($trow['TRANSACTION_NO']==10)
{


    $query = "UPDATE T_LANDS SET  STATUS = 0
    WHERE LAND_NO = '".$trow['LAND_NO']."' AND DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);

    $query = "UPDATE T_LANDS SET  AREA = AREA - ".$trow['T_AREA']."
    WHERE LAND_NO = '".$trow['SEC_LAND_NO']."' AND DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);



    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;
}else if($trow['TRANSACTION_NO']==11)
{

    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;

}else if($trow['TRANSACTION_NO']==12)
{


    $query = "UPDATE T_LANDS SET  STATUS = 0
    WHERE LAND_NO = '".$trow['LAND_NO']."' AND DISTRICT_NO = ".$trow['DISTRICT_NO'];
    mysqli_query($connect,$query);


    $query = "DELETE FROM T_TRANSACTION WHERE ID = ".$trans_id;
}


if (mysqli_query($connect,$query))
{
echo "done";
}


?>