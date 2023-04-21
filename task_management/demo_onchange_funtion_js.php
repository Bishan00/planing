<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<html>
    <head>
        <title></title>    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>
            jQuery(document).ready(function($) {
    $("#asset_id").on('change', function() {
        var level = $(this).val();
//        alert(level);
        if(level){
               $.ajax ({
                type: 'POST',
                url: 'demo_on_chnage_code.php',
                data: { asset_tp: '' + level + '' },
                success : function(htmlresponse) {
                    $('#csnoID').append(htmlresponse);
//                    alert(htmlresponse);
                },error:function(e){
                alert("error");}
            });
        }
    });
});
            </script>
    </head>
    <body>
         <div class="col-sm-3">
                            <div class="form-group"><label for="">Asset Type</label>
                                <select id="asset_id" name="asset_tp" class="form-control">
                                    <option>--Select--</option>
                                    <option value="DES">Desktop</option>
                                    <option value="LAP">Laptop</option>                                     
                                    <option value="MON">Monitor</option>
                                    <option value="PRN">Printer</option>     
                                    <option value="NETM"> Modem</option>  
                                    <option value="NETS"> Switch</option>  
                                    <option value="NETW">WIFI</option>  
                                    <option value="NETR">Router</option>
                                </select>
                            </div>
                        </div>
                 <div class="col-sm-3">
                            <div class="form-group"><label for="">CSNO</label>
                                <!--<input class="form-control" name="csno" placeholder="CSNO" type="text">-->
                                <select id="csnoID" name="csno" class="form-control">
                               
                          
                                   
                                    
                                </select>
                            </div>
                        </div>
        
        
    </body>
    
</html>
