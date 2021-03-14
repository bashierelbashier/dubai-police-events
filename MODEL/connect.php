<?php

$connect = mysqli_connect("localhost", "root", "");
mysqli_select_db($connect, "EVENTS");
mysqli_set_charset($connect, 'UTF8');