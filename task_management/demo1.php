<?php include("header.php"); ?>

<div id="wrapper">
    <div class="main-content container">
        <div class="row small-spacing">
            <div class="col-lg-12 col-xs-12">
                <div class="box-content" style="overflow-x:scroll;">
                    <h4 class="box-title">Contact List</h4>
                    <!-- /.box-title -->

                    <!-- /.dropdown js__dropdown -->
                    <div class="table-responsive table-purchases">
                        <table class="table table-striped margin-bottom-10">
                            <thead>
                                <tr style="font-size:14px;">
                                    <th>S No.</th>
                                    <th>Name</th>
                                    <th>Father's Name</th>
                                    <th>DOB</th>
                                    <!--<th>Email</th>-->
                                    <th>Mobile 1</th>
                                    <th>Mobile 2</th>
                                    <th>Qualification</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $link = mysqli_connect("localhost", "piit_piit", "JBU~)ebOqi1K", "piit_prateeek");
                                // if(isset($_GET['deleteid']))
                                // {
                                // 	$ID=$_GET['deleteid'];
                                // 	$query="delete from from aptitude_test where reg_id='$ID'";
                                // 	mysqli_query($link,$query);
                                // }

                                $result = mysqli_query($link, "select * from aptitude_test");
                                $count = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                    $count++;
                                    $reg_id = $row['reg_id'];
                                    $name = $row['name'];
                                    $father_nm = $row['father_nm'];
                                    $dob = $row['dob'];
                                    $mobile1 = $row['mobile1'];
                                    $mobile2 = $row['mobile2'];
                                    $qualification = $row['qualification'];
                                    $address = $row['address'];
                                    $Status = $row['Status'];
                                    $created = $row['created'];
                                    ?>
                                    <tr style="font-size:13px;">
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $father_nm; ?></td>
                                        <td><?php echo $dob; ?></td>

                                        <td><?php echo $mobile1; ?></td>
                                        <td><?php echo $mobile2; ?></td>
                                        <td><?php echo $qualification; ?></td>
                                        <td><?php echo $address; ?></td>
                                        <td><?php echo $Status; ?></td>
                                        <td><?php echo $created; ?></td>
                                        <td> &nbsp;&nbsp; <a href="reg_list.php?deleteid=<?php echo $reg_id; ?>"><i class="fa fa-remove" aria-hidden="true"></i></a></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-content -->
            </div>
            <!-- /.col-lg-6 col-xs-12 -->
        </div>
        <?php include("footer.php"); ?>
        </body>
        </html>