<?php

if ($row['IDENTITY_TYPE']==1)
    $row['IDENTITY_TYPE']=' رقم وطني ';
else if($row['IDENTITY_TYPE']==2)
    $row['IDENTITY_TYPE']=' بطاقة قومية ';
else if($row['IDENTITY_TYPE']==3)
    $row['IDENTITY_TYPE']=' جواز سفر ';
else if($row['IDENTITY_TYPE']==4)
    $row['IDENTITY_TYPE']=' جواز سفر ';
else if($row['IDENTITY_TYPE']==0) {
    $row['IDENTITY_TYPE'] = ' لايوجد ';
    $row['IDENTITY_NO']='-------';
}

?>