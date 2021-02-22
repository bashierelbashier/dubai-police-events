<?php

    $output = "";

    $land = $_POST['land'];
    $district = $_POST['district'];

    include "connect.php";

    $query = "SELECT * FROM T_DOCS WHERE LAND_NO = '".$land."' AND DISTRICT_NO =".$district;

    $res = mysqli_query($connect,$query);

    while ($row = mysqli_fetch_array($res))
    {
        $output .= '<a href="docs_gallery.php?LAND_NO='.$land.'&DISTRICT_NO='.$district.'&DOC_SOURCE=' . $row['DOC_FILE'] . '" target="_blank"><img style="border-color:lightblue;border-width:3px;border-style:solid;margin:10px;" src="../IMAGES/' . $row['DOC_FILE'] . '" height="200"/></a>';
    }

    if ($output!="")
        echo $output;
    else
        echo "<h1 align='center'>ليست هناك أي مستندات محفوظة لقطعة الأرض هذه</h1>";

?>