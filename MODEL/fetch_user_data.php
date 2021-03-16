<?php

include "connect.php";

header('Content-type: application/json; charset=utf-8');

$query = "SELECT * FROM T_USERS WHERE USER_NO = " . $_POST['id'];
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

echo json_encode([
    'full_name' => $row['FULL_NAME'],
    'user_name' => $row['USER_NAME'],
    'privilege_no' => $row['PRIVILEGE_NO'],
    'active' => $row['ACTIVE'],
    'img_signature' => $row['IMG_SIGNATURE'],
    'rank' => $row['RANK'],
]);

/*
$output = '';
$radio = '';
$select = '';
if ($row['ACTIVE'] == TRUE)
    $radio = '
                  <input checked type="radio" name="active" id="active" value="1">
                  <label>نشط</label>
                  <input type="radio" name="active" id="active" value="0">
                  <label>غير نشط</label>
              ';
else
    $radio = '
                  <input type="radio" name="active" id="active" value="1">
                  <label>نشط</label>
                  <input checked type="radio" name="active" id="active" value="0">
                  <label>غير نشط</label>
              ';


if ($row['PRIVILEGE_NO'] == 1)
    $select = '<select id="privilege" name="privilege" class="form-control text-center">
                                    <option value="1" selected> كامل الصلاحيات (آدمن) </option>
                                    <option value="2"> ضابط </option>
                                </select>';
else if ($row['PRIVILEGE_NO'] == 2)
    $select = '<select id="privilege" name="privilege" class="form-control text-center">
                                    <option value="1"> كامل الصلاحيات (آدمن) </option>
                                    <option value="2" selected> ضابط </option>
                                </select>';



$output .=
    '
    <table class="table table-responsive">
                        <tr>
                            <td>
                                <label>الإسم</label>
                            </td>
                            <td>
                                <input type="text" value="' . $row['FULL_NAME'] . '" required class="form-control text-center" id = "full_name" name="full_name" autocomplete="off"/>
                            </td>
                            <td>
                                <label>الرقم العسكري (للتعريف)</label>
                            </td>
                            <td>
                                <input type="text" value="' . $row['USER_NAME'] . '" required class="form-control text-center" id="user_name" name="user_name" autocomplete="off"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>كلمة المرور</label>
                            </td>
                            <td>
                                <input type="text" required class="form-control text-center" id = "password" name="password" autocomplete="off"/>
                            </td>
                            <td>
                                <label>درجة الصلاحية</label>
                            </td>
                            <td>
                                ' . $select . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>نشط ؟</label>
                            </td>
                            <td>
                                ' . $radio . '
                            </td>
                        </tr>
                    </table>
    ';


echo $output;
*/