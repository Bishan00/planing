      <!--------------------
                START - Mobile Menu
                -------------------->
                <div class="menu-mobile menu-activated-on-click color-scheme-dark">
                    <div class="mm-logo-buttons-w"><a class="mm-logo" href="#"><span>Atire Planing epartment</span></a>
                        <div class="mm-buttons">
                            <div class="content-panel-open">
                                <div class="os-icon os-icon-grid-circles"></div>
                            </div>
                            <div class="mobile-menu-trigger">
                                <div class="os-icon os-icon-hamburger-menu-1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-and-user">
                        <div class="logged-user-w">
                            <div class="avatar-w"><img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>"></div>
                            <div class="logged-user-info-w">
                                <div class="logged-user-name"><?php echo $_SESSION['emp_name'];?></div>
                                <div class="logged-user-role"><?php echo $_SESSION['User_type'];?></div>
                            </div>
                        </div>
                        <!--------------------
                        START - Mobile Menu List
                        -------------------->
                                    <?php if ($_SESSION['User_type']=="admin")
                    {
                        
                    ?>
                           <ul class="main-menu" style="height: 840px;">
                        <li class="">
                            <a href="Dashboard.php">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-layout"></div>
                                </div><span>Dashboard</span></a>

                        </li>
                        <li class="sub-header"><span>Settings</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-ui-46"></div>
                                </div><span>Settings</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Settings</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="bank_details.php">Bank Details</a></li>
                                        <li><a href="download.php">Document Upload</a></li>
                                        <li><a href="add_alert.php">Alert</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="sub-header"><span>User Manager</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-users"></div>
                                </div><span>Employee User</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Employee User</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="employee.php?source=add_emp">Create Employee Account</a></li>
                                        <li><a href="employee.php">Employee Account List</a></li>
                                        <li><a href="employee_active.php">Employee Account Activate</a></li>
                                        <li><a href="employee_deactive.php">Deactivate Employee Account</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                   
                         <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>Task Management</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Task Management</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="assign_task.php">Assign Task</a></li>
                                        <li><a href="assign_task_list.php">Task List</a></li>  
                                        <li><a href="assign_task_open_list.php">Open Task</a></li>  
                                        <li><a href="assign_task_list_close.php">Close Task</a></li>  
                                        <li><a href="assign_task_list_wip.php">WIP(Work In Process) Task</a></li>  
                                        <li><a href="assign_task_list_cancel.php">Cancel Task</a></li>  
                                    </ul>
                                </div>
                            </div>
                        </li>

                    </ul>
                    
                        <?php 
                    }
 else {?>
                           <ul class="main-menu" style="height: 840px;">
                        <li class="">
                            <a href="Dashboard.php">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-layout"></div>
                                </div><span>Dashboard</span></a>

                        </li>
                           <li class="sub-header"><span>Settings</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-ui-46"></div>
                                </div><span>Settings</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Settings</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="bank_details.php">Bank Details</a></li>
                                        <li><a href="download.php">Document Upload</a></li>
                                        <!--<li><a href="add_alert.php">Alert</a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </li>
                         <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-ui-46"></div>
                                </div><span>Send Bulk Email</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Send Bulk Email</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="send_bulk_email.php">Send Bulk Email</a></li>
<!--                                        <li><a href="download.php">Document Upload</a></li>-->
                                    
                                    </ul>
                                </div>
                            </div>
                        </li>

                   
                         <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>Task Management</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Task Management</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="emp_assign_task.php">Assign Task</a></li>
                                        <li><a href="emp_assign_task_list.php">Task List</a></li>  
                                        <li><a href="emp_assign_task_list_open.php">Open Task</a></li>  
                                        <li><a href="emp_assign_task_list_close.php">Close Task</a></li>  
                                        <li><a href="emp_assign_task_list_wip.php">WIP(Work In Process) Task</a></li>  
                                        <li><a href="emp_assign_task_list_cancel.php">Cancel Task</a></li>  
                                    </ul>
                                </div>
                            </div>
                        </li>

                    </ul>
                    <?php     
 }
?>
                        <!--------------------
                        END - Mobile Menu List
                        -------------------->

                    </div>
                </div>
                <!--------------------
                END - Mobile Menu
                -------------------->
                <!--------------------
                START - Main Menu
                -------------------->
                <div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
                    <div class="logo-w">
                        <a class="logo" href="#">
                            <div class="logo-element"></div>
                            <div class="logo-label"> Atire Planning department</div>
                        </a>
                    </div>
<!--                      <div class="logged-user-w">
                            <div class="avatar-w"><img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>"></div>
                            <div class="logged-user-info-w">
                                <div class="logged-user-name"><?php echo $_SESSION['emp_name'];?></div>
                                <div class="logged-user-role"><?php echo $_SESSION['User_type'];?></div>
                            </div>
                        </div>-->
                    <div class="logged-user-w avatar-inline">
                        <div class="logged-user-i">
                            <div class="avatar-w"><img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>"></div>
                            <div class="logged-user-info-w">
                                <div class="logged-user-name"><?php echo $_SESSION['emp_name'];?></div>
                                <div class="logged-user-role"><?php echo $_SESSION['User_type'];?></div>
                            </div>
                            <div class="logged-user-toggler-arrow">
                                <div class="os-icon os-icon-chevron-down"></div>
                            </div>
                            <div class="logged-user-menu color-style-bright">
                                <div class="logged-user-avatar-info">
                                    <div class="avatar-w"><img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>"></div>
                                    <div class="logged-user-info-w">
                                        <div class="logged-user-name"><?php echo $_SESSION['emp_name'];?></div>
                                <div class="logged-user-role"><?php echo $_SESSION['User_type'];?></div>
                                    </div>
                                </div>
                                <div class="bg-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <ul>
                                   <li><a href="update_emp_profile.php"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a></li>
                                    <li><a href="change_password.php"><i class="os-icon os-icon-others-43"></i><span>Change Password</span></a></li>
                                    <li><a href="logout.php"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="menu-actions">
                   
                    </div>
                    <div class="element-search autosuggest-search-activator">
<!--                        <input placeholder="Start typing to search..." type="text">-->
                    </div>
                    <h1 class="menu-page-header">Page Header</h1>
                    <?php if ($_SESSION['User_type']=="admin")
                    {
                        
                    ?>
                           <ul class="main-menu" style="height: 840px;">
                        <li class="">
                            <a href="Dashboard.php">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-layout"></div>
                                </div><span>Dashboard</span></a>

                        </li>
                       
                        <li class="sub-header"><span>User Manager</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-users"></div>
                                </div><span>Compound Planning</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Compound Planning</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="add_compound.php">Add comopund</a></li>
                                       
                                    </ul>
                                </div>
                            </div>
                        </li>
                   
                         <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>Stocks</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">stock</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    
                                    <ul class="sub-menu">
                                        <li><a href="assign_task.php">Add Stock</a></li>
                                        
                                    </ul>
                                  
                                </div>
                            </div>
                        </li>
                                   <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>Orders</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Orders</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                            <li><a href="add_order.php">Add Order</a></li>
                                          
                                           
                                    </ul>
                                </div>
                            </div>
                        </li>

                        
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>BOM</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Bom</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                            <li><a href="add_order.php">add BOM</a></li>
                                          
                                           
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>Curing plan</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Curing Plan</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                            <li><a href="add_curing.php">add curing plan</a></li>
                                          
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <li class="sub-header"><span>Settings</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-ui-46"></div>
                                </div><span>Settings</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Settings</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                     
                                        <li><a href="add_alert.php">Alert</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                    </ul>
                    
                        <?php 
                    }
 else {?>
                           <ul class="main-menu" style="height: 840px;">
                        <li class="">
                            <a href="Dashboard.php">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-layout"></div>
                                </div><span>Dashboard</span></a>

                        </li>
                           <li class="sub-header"><span>Settings</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-ui-46"></div>
                                </div><span>Settings</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Settings</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="bank_details.php">Bank Details</a></li>
                                        <li><a href="download.php">Document Upload</a></li>
                                        <!--<li><a href="add_alert.php">Alert</a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </li>
<!--                        <li class="sub-header"><span>Settings</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-ui-46"></div>
                                </div><span>Settings</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Settings</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="bank_details.php">Bank Details</a></li>
                                        <li><a href="download.php">Download</a></li>
                                        <li><a href="add_alert.php">Alert</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="sub-header"><span>User Manager</span></li>
                        <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-users"></div>
                                </div><span>Employee User</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Employee User</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="employee.php?source=add_emp">Create Employee Account</a></li>
                                        <li><a href="employee.php">Employee Account List</a></li>
                                        <li><a href="employee_active.php">Employee Account Activate</a></li>
                                        <li><a href="employee_deactive.php">Deactivate Employee Account</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>-->
                      <!-- <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-ui-46"></div>
                                </div><span>Send Bulk Email</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Send Bulk Email</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-users"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="send_bulk_email.php">Send Bulk Email</a></li>
                                    
                                    </ul>
                                </div>
                            </div>
                        </li> -->

                         <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>Task Management</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Task Management</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                        <li><a href="emp_assign_task.php">Assign Task</a></li>
                                        <li><a href="emp_assign_task_list.php">Task List</a></li>  
                                        <li><a href="emp_assign_task_list_open.php">Open Task</a></li>  
                                        <li><a href="emp_assign_task_list_close.php">Close Task</a></li>  
                                        <li><a href="emp_assign_task_list_wip.php">WIP(Work In Process) Task</a></li>  
                                        <li><a href="emp_assign_task_list_cancel.php">Cancel Task</a></li>  
                                    </ul>
                                </div>
                            </div>
                        </li>
       <!-- <li class=" has-sub-menu">
                            <a href="#">
                                <div class="icon-w">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div><span>Asset Management System</span></a>
                            <div class="sub-menu-w">
                                <div class="sub-menu-header">Asset Management System</div>
                                <div class="sub-menu-icon"><i class="os-icon os-icon-wallet-loaded"></i></div>
                                <div class="sub-menu-i">
                                    <ul class="sub-menu">
                                    <li><a href="add_assets.php">Add Asset</a></li>
                                         <li><a href="assets_list.php">Asset List</a></li>
                                        <li><a href="emp_assign_assets.php">Assign Employee Asset</a></li>  

                                    </ul>
                                </div>
                            </div>
                        </li> -->
                    </ul>
                    <?php     
 }
?>
             

                </div>
                <!--------------------
                END - Main Menu
                -------------------->