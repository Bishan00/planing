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
        $icode = $foo[$count][0];
        $t_size = $foo[$count][1];
        $brand = $foo[$count][2];
        $col = $foo[$count][3];
        $fit= $foo[$count][4];
        $rim = $foo[$count][5];
        $cons = $foo[$count][6];
        $fweight= $foo[$count][7];
        $ptv= $foo[$count][8];
         $new= $foo[$count][9];
         $cbm= $foo[$count][10];
         $kgs= $foo[$count][11];

     


        $query = "INSERT INTO worder (icode,t_size,brand,col,fit,rim,cons,fweight,ptv,new,cbm,kgs) ";
        $query.="VALUES ('$icode','$t_size','$brand','$col','$fit','$rim','$cons','$fweight','$ptv','$new','$cbm','$kgs')";
        mysqli_query($db,$query);
        $count++;
    }

    echo "<script>window.location.href='work_order.php';</script>";
               
    
    
               
    
    
}
   
    
    
}
?>