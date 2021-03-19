<?php
include "connect.php";
$id = $_POST['doc_source'];
$query = "DELETE FROM T_DOCS WHERE DOC_FILE='".$id."'";
$res = mysqli_query($connect,$query);
$del = unlink("../IMAGES/".$id);

if ($res&&$del){
    echo "done";
}

?>
