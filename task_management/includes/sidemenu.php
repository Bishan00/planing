<!DOCTYPE html>
<html>
<head>
    <style>
        /* Reset some default styles */
        body, ul, li {
            margin: 0;
            padding: 0;
        }

        /* Define styles for the menu container */
        .menu-container {
            background-color: #f28018; /* Background color */
            color: #fff; /* Text color */
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
    </style>
</head>
<body>
    <div class="menu-container">
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
            <ul class="main-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                
                <li class="menu-divider"></li>
                <li><a href="add_workorder.php">Add Work Order</a></li>
                <li><a href="comparee.php">Check Work Order</a></li>
                <li><a href="workdelete.php">Delete Work Order</a></li>
                <li class="menu-divider"></li>
                <li><a href="convertstock.php">Set Work Order Plan</a></li>
                <li><a href="deleteplan.php">Delete Plan</a></li>
                <li><a href="updatedate.php">Update Plan</a></li>
                <li><a href="time_range2.php">Set Shift Plan</a></li>
                <li class="menu-divider"></li>
                <li><a href="add_daily_production.php">Add Daily Production</a></li>
                <li class="menu-divider"></li>
                <li><a href="dispatch.php">Add Dispatch  Order</a></li>
                <li class="menu-divider"></li>
                <li><a href="add_reject.php">Add Daily Reject</a></li>
                <li class="menu-divider"></li>
            </ul>
        </div>
    </div>
</body>
</html>
