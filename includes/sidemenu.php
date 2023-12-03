<!DOCTYPE html>
<html>
<head>
    <style>
        /* Reset some default styles */
        body, ul, li {
            margin: 0;
            padding: 0;
            background-color: #f28018;
        }

        /* Define styles for the menu container */
        .menu-containerr {
            background-color: #f28018; /* Background color */
            color: #fff; /* Text color */
            weight:50%;
            font-family: 'Cantarell', sans-serif; /* Use Cantarell font or fallback to sans-serif */
        }

        .menu-header {
            background-color: #000000; /* Header background color */
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        .menu-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .logo-image {
            width: 125px;
            height: 21.25px;
            margin-right: 10px;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            color: #f28018; /* Text color for user info */
        }

        .user-name {
            font-weight: bold;
            font-size: 1.2em;
            font-family: 'Cantarell', sans-serif; /* Use Cantarell font or fallback to sans-serif */
        }

        .user-role {
            font-size: 1em;
            font-family: 'Cantarell', sans-serif; /* Use Cantarell font or fallback to sans-serif */
        }

        .menu-items {
            padding: 10px;
        }

        .main-menu {
            list-style: none;
        }

        .main-menu li {
            margin-bottom: 10px;
        }

        .main-menu a {
            text-decoration: none;
            color: #fff;
            display: inline-block;
            padding: 10px 20px;
            width: 200px; /* Fixed width for all buttons */
            height: 40px; /* Fixed height for all buttons */
            background-color: #000000; /* Button background color */
            border-radius: 50px; /* Rounded corners */
            font-weight: bold; /* Make text bold */
            text-align: center; /* Center the text */
            font-family: 'Cantarell', sans-serif; /* Use Cantarell font or fallback to sans-serif */
        }

        .main-menu a:hover {
            background-color: #f28018; /* Background color on hover */
        }

        /* Add a line separator between menu items */
        .menu-divider {
            border-top: 1px solid #f28018; /* Divider color */
            margin-top: 5px;
            margin-bottom: 5px;
        }

        /* Submenu Styles */
        .main-menu li {
            position: relative;
        }
        /* Change the color of the submenu button text */
.submenu li a {
    color: #000000; 
    background-color: #FFFFFF;/* Change the color of the submenu button text (can change this color) */
}

        .submenu {
            display: none;
           
            top: 0;
            left: 30%;
            
        }

        .submenu li::before {
    content: "●"; /* Use a bullet point character as content */
    color: #f28018; /* Color of the bullet point */
    display: inline-block;
    width: 15px; /* Adjust the width of the bullet point */
     /* Negative margin to position the bullet point */
}
        .main-menu li:hover .submenu {
            display: block;
        }


    </style>
</head>
<body>
    <!--------------------
                START - Mobile Menu
                -------------------->

                <?php 
if ($_SESSION['User_type'] == "admin") {
    // Admin menu
?>
<div class="menu-containerr">
        <div class="menu-header">
            <a class="menu-logo" href="#">
                <img src="atire.png" alt="Your Logo" class="logo-image">
            </a>
            <div class="user-profile">
                <div class="avatar">
                    <img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['emp_name'];?></div>
                    <div class="user-role"><?php echo $_SESSION['User_type'];?></div>
                </div>
            </div>
        </div>
        <div class="menu-items">
            <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: left; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Operational</h6>
            <ul class="main-menu">
                <!-- Topic 1: Work Order -->
                <li class="menu-divider">
                    <a href="#">Work Order</a>
                    <ul class="submenu">
                        <li><a href="add_workorder.php">Work order - New</a></li>
                        <li><a href="comparee.php">Work order - Verify</a></li>
                        <li><a href="workdelete.php">Work order - Remove</a></li>
                       
                    </ul>
                </li>
                <!-- Topic 2: Plan Management -->
                <li class="menu-divider">
                    <a href="#">Production plan</a>
                    <ul class="submenu">
                    <li><a href="convertstock.php">Plan - Work order</a></li>
                        <li><a href="deleteplan.php">Plan - Remove</a></li>
                        <li><a href="updatedate.php">Plan - Update</a></li>
                        <li><a href="time_range2.php">Plan - Shift Vise</a></li>
                        <li><a href="date_update.php">Plan - Date Change</a></li>
                    </ul>
                </li>
                <!-- Topic 3: Daily Production -->
                <li class="menu-divider">
                    <a href="#">Tires Input</a>
                    <ul class="submenu">
                        <li><a href="add_daily_production.php">Daily production</a></li>
                    </ul>
                </li>
                <!-- Topic 4: Dispatch -->
                <li class="menu-divider">
                    <a href="#">Tires Output -QA</a>
                    <ul class="submenu">
                        <li><a href="add_reject.php">Daily Reject</a></li>
                        <li><a href="add_rejectb.php">Daily B Grade</a></li>
                        <li><a href="">Daily Hold</a></li>
                    </ul>
                </li>
                <!-- Topic 5: Daily Reject -->
                <li class="menu-divider">
                    <a href="#">Tire Output - Sales
</a>
                    <ul class="submenu">
                        <li><a href="dispatch.php">Order Despatch</a></li>
                    </ul>
                </li>
                <!-- Add more topics and menu items as needed -->

                  <!-- New Button 1 -->
    
        
   
            </ul>
        </div>
        <!DOCTYPE html>
<html>
<head>
<style>
  .red-text {
    color:#f28018 ;
  }
  .blue-text {
    color:#f28018;
  }
  /* Add more styles as needed */
</style>
</head>
<body>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
</body>
</html>

    </div>

   
<?php
}

elseif ($_SESSION['User_type'] == "Planning") {
    // Admin menu
?>
<div class="menu-containerr">
        <div class="menu-header">
            <a class="menu-logo" href="#">
                <img src="atire.png" alt="Your Logo" class="logo-image">
            </a>
            <div class="user-profile">
                <div class="avatar">
                    <img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['emp_name'];?></div>
                    <div class="user-role"><?php echo $_SESSION['User_type'];?></div>
                </div>
            </div>
        </div>
        <div class="menu-items">
            <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: left; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Operational</h6>
            <ul class="main-menu">
                <!-- Topic 1: Work Order -->
                <li class="menu-divider">
                    <a href="#">Work Order</a>
                    <ul class="submenu">
                        <li><a href="add_workorder.php">Work order - New</a></li>
                        <li><a href="comparee.php">Work order - Verify</a></li>
                        <li><a href="workdelete.php">Work order - Remove</a></li>
                       
                    </ul>
                </li>
                <!-- Topic 2: Plan Management -->
                <li class="menu-divider">
                    <a href="#">Production plan</a>
                    <ul class="submenu">
                    <li><a href="convertstock.php">Plan - Work order</a></li>
                        <li><a href="deleteplan.php">Plan - Remove</a></li>
                        <li><a href="updatedate.php">Plan - Update</a></li>
                        <li><a href="time_range2.php">Plan - Shift Vise</a></li>
                        <li><a href="date_update.php">Plan - Date Change</a></li>
                    </ul>
                </li>
                <!-- Topic 3: Daily Production -->
                <li class="menu-divider">
                    <a href="#">Tires Input</a>
                    <ul class="submenu">
                        <li><a href="add_daily_production.php">Daily production</a></li>
                    </ul>
                </li>
                <!-- Topic 4: Dispatch -->
                <li class="menu-divider">
                    <a href="#">Tires Output -QA</a>
                    <ul class="submenu">
                        <li><a href="add_reject.php">Daily Reject</a></li>
                        <li><a href="add_rejectb.php">Daily B Grade</a></li>
                        <li><a href="">Daily Hold</a></li>
                    </ul>
                </li>
                <!-- Topic 5: Daily Reject -->
                <li class="menu-divider">
                    <a href="#">Tire Output - Sales
</a>
                    <ul class="submenu">
                        <li><a href="dispatch.php">Order Despatch</a></li>
                    </ul>
                </li>
                <!-- Add more topics and menu items as needed -->

                  <!-- New Button 1 -->
    
        
   
            </ul>
        </div>
        <!DOCTYPE html>
<html>
<head>
<style>
  .red-text {
    color:#f28018 ;
  }
  .blue-text {
    color:#f28018;
  }
  /* Add more styles as needed */
</style>
</head>
<body>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
</body>
</html>

    </div>

   
<?php
}
elseif ($_SESSION['User_type'] == "fmanager") {
   
?>



<div class="menu-containerr">
        <div class="menu-header">
            <a class="menu-logo" href="#">
                <img src="atire.png" alt="Your Logo" class="logo-image">
            </a>
            <div class="user-profile">
                <div class="avatar">
                    <img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['emp_name'];?></div>
                    <div class="user-role"><?php echo $_SESSION['User_type'];?></div>
                </div>
            </div>
        </div>
        <div class="menu-items">
            <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: left; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Operational</h6>
            <ul class="main-menu">
                <!-- Topic 1: Work Order -->
                <li class="menu-divider">
                    <a href="#">Tire input</a>
                    <ul class="submenu">
                    <ul class="submenu">
                        <li><a href="confirm_daily.php">Confirm Production</a></li>
                    </ul>
   
            </ul>
        </div>
        <!DOCTYPE html>
<html>
<head>
<style>
  .red-text {
    color:#f28018 ;
  }
  .blue-text {
    color:#f28018;
  }
  /* Add more styles as needed */
</style>
</head>
<body>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
</body>
</html>

    </div>

<div class="menu-container">
    <!-- Customize this part for other_user_type -->
</div>
<?php
} 


elseif ($_SESSION['User_type'] == "qmanager") {
   
    ?>
    
    
    
    <div class="menu-containerr">
        <div class="menu-header">
            <a class="menu-logo" href="#">
                <img src="atire.png" alt="Your Logo" class="logo-image">
            </a>
            <div class="user-profile">
                <div class="avatar">
                    <img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['emp_name'];?></div>
                    <div class="user-role"><?php echo $_SESSION['User_type'];?></div>
                </div>
            </div>
        </div>
        <div class="menu-items">
            <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: left; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Operational</h6>
            <ul class="main-menu">
             
                <!-- Topic 4: Dispatch -->
                <li class="menu-divider">
                    <a href="#">Tires Output -QA</a>
                    <ul class="submenu">
                        <li><a href="showdaily2.php">Daily Reject</a></li>
                        <li><a href="showdaily2b.php">Daily B Grade</a></li>
                        <li><a href="hold_tireb.php">Daily Hold</a></li>
                    </ul>
                </li>
                   <!-- Topic 4: Dispatch -->
                   <li class="menu-divider">
                    <a href="#">BOM</a>
                    <ul class="submenu">
                        <li><a href="insert_bom.php">Add Bom</a></li>
                      
                    </ul>
                </li>
               
               
   
            </ul>
        </div>
        <!DOCTYPE html>
<html>
<head>
<style>
  .red-text {
    color:#f28018 ;
  }
  .blue-text {
    color:#f28018;
  }
  /* Add more styles as needed */
</style>
</head>
<body>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
</body>
</html>

    </div>

   
<?php
    }


    elseif ($_SESSION['User_type'] == "stock") {
   
        ?>
        
        
        
        <div class="menu-containerr">
            <div class="menu-header">
                <a class="menu-logo" href="#">
                    <img src="atire.png" alt="Your Logo" class="logo-image">
                </a>
                <div class="user-profile">
                    <div class="avatar">
                        <img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>">
                    </div>
                    <div class="user-info">
                        <div class="user-name"><?php echo $_SESSION['emp_name'];?></div>
                        <div class="user-role"><?php echo $_SESSION['User_type'];?></div>
                    </div>
                </div>
            </div>
            <div class="menu-items">
                <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: left; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Operational</h6>
                <ul class="main-menu">
                 
                <li class="menu-divider">
                    <a href="#">Tire Output - Sales
</a>
                    <ul class="submenu">
                        <li><a href="dispatch.php">Order Despatch</a></li>
                    </ul>
                </li>
       
                </ul>
            </div>
            <!DOCTYPE html>
    <html>
    <head>
    <style>
      .red-text {
        color:#f28018 ;
      }
      .blue-text {
        color:#f28018;
      }
      /* Add more styles as needed */
    </style>
    </head>
    <body>
      <p class="red-text">ddddddddddddddddddd</p>
      <p class="red-text">ddddddddd</p>
      <p class="blue-text">ddddddd</p>
      <p class="red-text">dddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
    </body>
    </html>
    
        </div>
    
       
    <?php
        }
    elseif ($_SESSION['User_type'] == "qad") {
   
        ?>
        
        
        
        <div class="menu-containerr">
            <div class="menu-header">
                <a class="menu-logo" href="#">
                    <img src="atire.png" alt="Your Logo" class="logo-image">
                </a>
                <div class="user-profile">
                    <div class="avatar">
                        <img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>">
                    </div>
                    <div class="user-info">
                        <div class="user-name"><?php echo $_SESSION['emp_name'];?></div>
                        <div class="user-role"><?php echo $_SESSION['User_type'];?></div>
                    </div>
                </div>
            </div>
            <div class="menu-items">
                <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: left; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Operational</h6>
                <ul class="main-menu">
                <li class="menu-divider">
                    <a href="#">Tires Output -QA</a>
                    <ul class="submenu">
                        <li><a href="add_reject.php">Daily Reject</a></li>
                        <li><a href="add_rejectb.php">Daily B Grade</a></li>
                        <li><a href="add_hold.php">Daily Hold</a></li>
                    </ul>
                </li>
                   
       
                </ul>
            </div>
            <!DOCTYPE html>
    <html>
    <head>
    <style>
      .red-text {
        color:#f28018 ;
      }
      .blue-text {
        color:#f28018;
      }
      /* Add more styles as needed */
    </style>
    </head>
    <body>
      <p class="red-text">ddddddddddddddddddd</p>
      <p class="red-text">ddddddddd</p>
      <p class="blue-text">ddddddd</p>
      <p class="red-text">dddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
      <p class="red-text">dddddddddddddddddd</p>
    </body>
    </html>
    
        </div>
    
       
    <?php
        }

else {
    // Default menu for users who don't match any specific user type
?>

<div class="menu-containerr">
        <div class="menu-header">
            <a class="menu-logo" href="#">
                <img src="atire.png" alt="Your Logo" class="logo-image">
            </a>
            <div class="user-profile">
                <div class="avatar">
                    <img alt="" src="user_profile/<?php echo $_SESSION['emp_pro'];?>">
                </div>
                <div class="user-info">
                    <div class="user-name"><?php echo $_SESSION['emp_name'];?></div>
                    <div class="user-role"><?php echo $_SESSION['User_type'];?></div>
                </div>
            </div>
        </div>
        <div class="menu-items">
            <h6 style="background-color: #000000; color: #fff; border-radius: 50px; padding: 3px; text-align: left; font-weight: bold; font-family: 'Cantarell', sans-serif;">Dashboard - Operational</h6>
            <ul class="main-menu">
                <!-- Topic 1: Work Order -->
                <li class="menu-divider">
                    <a href="#">Tire input</a>
                    <ul class="submenu">
                    <ul class="submenu">
                        <li><a href="add_daily_production.php">Daily production</a></li>
                    </ul>
   
            </ul>
        </div>
        <!DOCTYPE html>
<html>
<head>
<style>
  .red-text {
    color:#f28018 ;
  }
  .blue-text {
    color:#f28018;
  }
  /* Add more styles as needed */
</style>
</head>
<body>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">ddddddddddddddddddd</p>
  <p class="red-text">ddddddddd</p>
  <p class="blue-text">ddddddd</p>
  <p class="red-text">dddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
  <p class="red-text">dddddddddddddddddd</p>
</body>
</html>

    </div>

   
<div class="menu-container">
    <!-- Customize this part for the default menu -->
</div>
<?php
}
?>
