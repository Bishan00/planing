<html>
    <head>        
        <title></title>
    </head>
    <body>
        <?php 
        include './includes/db.php';
if(isset($_POST["Import"]))
{
    //First we need to make a connection with the database
//    $host='localhost';
//    $db_user= 'root'; 
//    $db_password= '';
//    $db= 'product_record';
//    $conn=mysql_connect($host,$db_user,$db_password) or die (mysql_error());
//    mysql_select_db($db) or die (mysql_error());
    echo $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        //$sql_data = "SELECT * FROM prod_list_1 ";
        while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
            //print_r($emapData);
            //exit();
            $sql = "INSERT into prod_list_1(p_bench,p_name,p_price,p_reason) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]')";
            mysqli_query($connection,$sql);
            sleep(60);
        }
        fclose($file);
        echo 'CSV File has been successfully Imported';
        //header('Location: index.php');
    }
    else
        echo 'Invalid File:Please Upload CSV File';
}
?>
        <form enctype="multipart/form-data" method="post" role="form">
    <div class="form-group">
        <label for="exampleInputFile">File Upload</label>
        <input type="file" name="file" id="file" size="150">
        <p class="help-block">Only Excel/CSV File Import.</p>
    </div>
    <button type="submit" class="btn btn-default" name="Import" value="Import">Upload</button>
</form>
    </body>
</html>