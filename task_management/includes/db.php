<?php
$db['db_host']="localhost";
$db['db_user']="planatir_task_management";
$db['db_pass']="Bishan@1919";
$db['db_name']="planatir_task_management";
foreach($db as $key => $value)
{
    define(strtoupper($key),$value);
}
//$connection =mysqli_connect('localhost','planatir_task_management','','global_touch');
$connection =mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
//    if($connection)
//    {
//        echo "we are connected";
//    }
?>