<?php
// Replace these variables with your actual database information
$hostname = 'localhost';
$username = 'planatir_task_management';
$password = 'Bishan@1919';
$database = 'planatir_task_management';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to update cstock in the stock table
    $sql = "
        UPDATE stock t2
        JOIN copied_work t1 ON t2.icode = t1.icode
        SET t2.cstock = CASE
            WHEN t2.cstock - CAST(t1.new AS UNSIGNED) < 0 THEN 0
            ELSE t2.cstock - CAST(t1.new AS UNSIGNED)
        END;
    ";

    // Execute the query
    $pdo->exec($sql);
    
    // Redirect to the desired page after updating
    header("Location: deletecopied2.php");
    exit();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
