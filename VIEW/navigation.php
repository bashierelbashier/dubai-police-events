<?php
if ($_SESSION['PRIVILEGE'] == 1)
    echo '<li><a href="../index.php"><i class="fa fa-dashboard"></i> لوحة المعلومات </a></li>
    <li><a href="events.php"><i class="fa fa-list"></i> قائمة الفعاليات </a></li>
    <li><a href="new_event.php"><i class="fa fa-plus"></i> إضافة فعالية </a></li>
    <li><a href="control_panel.php"><i class="fa fa-gears"></i> لوحة التحكم </a></li>';
else if ($_SESSION['PRIVILEGE'] == 2)
    echo '<li><a href="events.php"><i class="fa fa-list"></i> قائمة الفعاليات </a></li>
    <li><a href="new_event.php"><i class="fa fa-plus"></i> إضافة فعالية </a></li>';