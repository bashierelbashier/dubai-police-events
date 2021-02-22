<?php

if ($tdrow['FIRST_PARTY']!='')
{
    $fpquery = "SELECT * FROM T_OWNERS WHERE OWNER_NO = ".$tdrow['FIRST_PARTY'];
    $fpres = mysqli_query($connect,$fpquery);
    $fprow = mysqli_fetch_array($fpres);
    $tdrow['FIRST_PARTY'] = $fprow['OWNER_NAME'];
}


if ($tdrow['SEC_PARTY']!='')
{
    $spquery = "SELECT * FROM T_OWNERS WHERE OWNER_NO = ".$tdrow['SEC_PARTY'];
    $spres = mysqli_query($connect,$spquery);
    $sprow = mysqli_fetch_array($spres);
    $tdrow['SEC_PARTY'] = $sprow['OWNER_NAME'];
}


if ($row['TRANSACTION_NO']==1)
{
    $transaction_details = 'تم تخصيص القطعة ل '.$tdrow['FIRST_PARTY'].' لمدة '.$tdrow['PERIOD'].'سنوات. ';

}else if ($row['TRANSACTION_NO']==2)
{

    if ($tdrow['RENEWAL_TERM']==1)
        $tdrow['RENEWAL_TERM']='فترة أولى.';
    if ($tdrow['RENEWAL_TERM']==2)
        $tdrow['RENEWAL_TERM']='فترة ثانية.';
    if ($tdrow['RENEWAL_TERM']==3)
        $tdrow['RENEWAL_TERM']='فترة ثانية.';

    $transaction_details = ' تم تجديد إيجارة القطعة لمدة  '.$tdrow['PERIOD'].' سنوات ك'.$tdrow['RENEWAL_TERM'];

}else if ($row['TRANSACTION_NO']==3)
{
    $transaction_details = ' تنازل '.$tdrow['FIRST_PARTY'].' ل '.$tdrow['SEC_PARTY'].'.';

}else if ($row['TRANSACTION_NO']==4)
{
    $transaction_details = ' تم رهن القطعة ';

}else if ($row['TRANSACTION_NO']==5)
{
    $transaction_details = ' تم فك رهن القطعة ';

}else if ($row['TRANSACTION_NO']==6)
{
    $transaction_details = ' تم فرز مساحة قدرها '.$tdrow['AREA'].' فدان ل '.$tdrow['FIRST_PARTY'].
    ' وتمثيلها بقطعة أرض جديدة رقمها '.$tdrow['SEC_LAND_NO'].'.';

}else if ($row['TRANSACTION_NO']==7)
{
    $transaction_details = 'تقنيين';

}else if ($row['TRANSACTION_NO']==8)
{
    $transaction_details = ' تم تغيير غرض القطعة من زراعي إلى سكني. ';

}else if ($row['TRANSACTION_NO']==9)
{
    $transaction_details = ' تمت إضافة مساحة قدرها '.$tdrow['AREA'].' فدان إلى قطعة الأرض. ';

}else if ($row['TRANSACTION_NO']==10)
{
    $transaction_details = ' تم ضم قطعة الأرض إلى القطعة رقم '.$tdrow['SEC_LAND_NO'].'.';

}else if ($row['TRANSACTION_NO']==11)
{
    $transaction_details = ' تم إسترداد القطعة من مستأجريها. ';

}else if ($row['TRANSACTION_NO']==12)
{
    $transaction_details = ' تم نزع قطعة الأرض لمصلحة حكومة جمهورية السودان. ';
}


?>