<?php
use SimpleExcel\SimpleExcel;

if(isset($_POST['import'])){

if(move_uploaded_file($_FILES['excel_file']['tmp_name'],$_FILES['excel_file']['name'])){
    require_once('SimpleExcel/SimpleExcel.php'); 
    
    $excel = new SimpleExcel('csv');                  
    
    $excel->parser->loadFile($_FILES['excel_file']['name']);           
    
    $foo = $excel->parser->getField(); 

    $count = 1;
    $db = mysqli_connect('localhost','root','','task_management');

    while(count($foo)>$count){

        $date = $foo[$count][0];
        $Customer = $foo[$count][1];
        $wono = $foo[$count][2];
        $ref = $foo[$count][3];
        $erp = $foo[$count][4];
        $icode = $foo[$count][5];
        $t_size = $foo[$count][6];
        $brand = $foo[$count][7];
        $col = $foo[$count][8];
        $fit= $foo[$count][9];
        $rim = $foo[$count][10];
        $cons = $foo[$count][11];
        $fweight= $foo[$count][12];
        $ptv= $foo[$count][13];
         $new= $foo[$count][14];
         $cbm= $foo[$count][15];
         $kgs= $foo[$count][16];

     


        $query = "INSERT INTO worder (date,Customer,wono,ref,erp,icode,t_size,brand,col,fit,rim,cons,fweight,ptv,new,cbm,kgs) ";
        $query.="VALUES ('$date','$Customer','$wono','$ref','$erp','$icode','$t_size','$brand','$col','$fit','$rim','$cons','$fweight','$ptv','$new','$cbm','$kgs')";
        mysqli_query($db,$query);
        $count++;
    }

    echo "<script>window.location.href='work_order.php';</script>";
               
    
    
               
    
    
}
   
    
    
}
?>