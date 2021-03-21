<?php

$connect = mysqli_connect("localhost", "root", "");
// $connect = mysqli_connect("localhost", "bash", "kankan");
mysqli_select_db($connect, "EVENTS");
mysqli_set_charset($connect, 'UTF8');