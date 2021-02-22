<?php


include "connect.php";

$limit = $_POST['limit'];
$start = $_POST['start'];


if(isset($_POST['filter_from'])&& $_POST['filter_from']!=''&&isset($_POST['filter_to'])&& $_POST['filter_to']!=''&&isset($_POST['trans_no'])&& $_POST['trans_no']!=0) {

    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE TRANS_DATE >= '".$_POST['filter_from']."'
    AND TRANS_DATE <= '".$_POST['filter_to']."' AND TRANSACTION_NO = ".$_POST['trans_no'];

}else if(isset($_POST['filter_from'])&& $_POST['filter_from']!=''&&isset($_POST['trans_no'])&& $_POST['trans_no']!=0)
{
    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE TRANS_DATE >= '".$_POST['filter_from']."' AND TRANSACTION_NO = ".$_POST['trans_no'];

}else if(isset($_POST['filter_to'])&& $_POST['filter_to']!=''&&isset($_POST['trans_no'])&& $_POST['trans_no']!=0)
{
    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE TRANS_DATE <= '".$_POST['filter_to']."' AND TRANSACTION_NO = ".$_POST['trans_no'];;

}else if(isset($_POST['trans_no'])&& $_POST['trans_no']!=0)
{
    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE TRANSACTION_NO = ".$_POST['trans_no'];

}else if(isset($_POST['filter_from'])&& $_POST['filter_from']!=''&&isset($_POST['filter_to'])&& $_POST['filter_to']!='')
{
    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE TRANS_DATE >= '".$_POST['filter_from']."'
    AND TRANS_DATE <= '".$_POST['filter_to']."'";

}else if(isset($_POST['filter_from'])&& $_POST['filter_from']!='')
{
    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE TRANS_DATE >= '".$_POST['filter_from']."'";
}else if(isset($_POST['filter_to'])&& $_POST['filter_to']!='')
{
    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO) WHERE TRANS_DATE <= '".$_POST['filter_to']."'";
}else
{
    $query = "SELECT * FROM T_TRANSACTION JOIN T_LANDS USING (LAND_NO,DISTRICT_NO)
    JOIN T_DISTRICTS USING (DISTRICT_NO)";
}

$query .= " ORDER BY TRANS_DATE LIMIT ".$start.",".$limit;


$result= mysqli_query($connect,$query);

$output = "
<table class='table table-bordered'>";

$count = $start+1;

if (mysqli_num_rows($result)>0)
{

    while ($row=mysqli_fetch_array($result))
    {

        $trans_id = $row['ID'];
        include "process_transactions.php";

        $output .= "
    <tr id='".$trans_id."' class='transaction-row' style='cursor:pointer;' align='center'>
    <td width='10%'>".$count."</td>
    <td width='30%'>".$row['DISTRICT_NAME']."</td><td width='20%' >".$row['LAND_NO']."</td>
    <td width='20%'>".$row['TRANSACTION_NO']."</td><td width='20%'>".$row['TRANS_DATE']."</td>
    </tr>";

        $count++;
    }
}else{
    $output .='<tr align="center"><td colspan="5"> لاتوجد بيانات </td></tr>';

}

$output .= "</table>";

echo $output;

?>