<?php

if ($row['EVENT_TYPE'] == 1) {
    $row['EVENT_TYPE'] = 'بطولة رياضية';
}
elseif ($row['EVENT_TYPE'] == 2) {
    $row['EVENT_TYPE'] = 'مباراة';
}
elseif ($row['EVENT_TYPE'] == 3) {
    $row['EVENT_TYPE'] = 'سباق';
}
else {
    $row['EVENT_TYPE'] = $row['EVENT_TYPE'];
}