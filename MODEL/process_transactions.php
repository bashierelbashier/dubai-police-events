<?php


if ($row['TRANSACTION_NO']==1)
{
    $row['TRANSACTION_NO']='تخصيص';

}else if ($row['TRANSACTION_NO']==2)
{
    $row['TRANSACTION_NO']='تجديد';

}else if ($row['TRANSACTION_NO']==3)
{
    $row['TRANSACTION_NO']='تنازل';

}else if ($row['TRANSACTION_NO']==4)
{
    $row['TRANSACTION_NO']='رهن';

}else if ($row['TRANSACTION_NO']==5)
{
    $row['TRANSACTION_NO']='فك رهن';

}else if ($row['TRANSACTION_NO']==6)
{
    $row['TRANSACTION_NO']='فرز';

}else if ($row['TRANSACTION_NO']==7)
{
    $row['TRANSACTION_NO']='تقنيين';

}else if ($row['TRANSACTION_NO']==8)
{
    $row['TRANSACTION_NO']='تغيير غرض';

}else if ($row['TRANSACTION_NO']==9)
{
    $row['TRANSACTION_NO']='إضافة';

}else if ($row['TRANSACTION_NO']==10)
{
    $row['TRANSACTION_NO']='ضم';

}else if ($row['TRANSACTION_NO']==11)
{
    $row['TRANSACTION_NO']='إسترداد';

}else if ($row['TRANSACTION_NO']==12)
{
    $row['TRANSACTION_NO']='نزع';

}


?>