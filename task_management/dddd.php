<?php
// Load the INI file
$config = parse_ini_file('etc\php.ini');

// Retrieve database connection settings
$host = $config['localhost'];
$username = $config['planatir_task_management'];
$password = $config['bishan@1919'];
$dbname = $config['planatir_task_management'];
