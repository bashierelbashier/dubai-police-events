<?php

$connect = mysqli_connect("localhost", "bash", "kankan");
mysqli_select_db($connect, "ARCHIVE");
mysqli_set_charset($connect, 'UTF8');
