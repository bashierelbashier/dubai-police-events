<?php

session_start();

include "connect.php";

if (isset($_POST['username'])&& isset($_POST['password']))
{
    $sql = "SELECT * FROM T_USERS WHERE USER_NAME = '".$_POST['username']."' AND PASSWORD = '".md5($_POST['password'])."'";
    $res = mysqli_query($connect,$sql);

    if (mysqli_num_rows($res)>0)
    {

        $row = mysqli_fetch_array($res);

        if ($row['ACTIVE']==true)
        {
            $_SESSION['USER_NAME'] = $row['USER_NAME'];
            $_SESSION['USER_NO'] = $row['USER_NO'];
            $_SESSION['FULL_NAME'] = $row['FULL_NAME'];
            $_SESSION['PRIVILEGE'] = $row['PRIVILEGE_NO'];

            echo "GRANTED";

        }else{
            echo "INACTIVE";
        }

    }
}


?>
