<?php
include 'database.php';
$obj = new Database();
$obj->insert('students', ['student_name'=>'Wali Haider', 'age'=>2, 'city'=>'Sanglahill']);
echo 'Inserted result is : ';
print_r($obj->getResult());
?>