<!DOCTYPE html>
<html>
<head>
    <title>Dispacth Word Order</title>
    <style>
        body {
            font-family: 'Cantarell', sans-serif;
            background: url('atire3.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 50px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        h1 {
            color: #000000;
            font-weight: bold;
            font-size: 24px;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #F28018;
            color: #FFFFFF;
            padding: 10px 30px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Cantarell Bold', sans-serif;
        }

        input[type="submit"]:hover {
            background-color: #FFA726;
        }
    </style>
</head>
<body>
<div class="container">
    <form method="post" action="pros.php">

        <h3>Enter ERP Number: <input type="text" name="erp_number" required></h3>

        <label for="dispatch_date">Select Dispatch Date:</label>
        <input type="date" id="dispatch_date" name="dispatch_date" required>

        <br><br>
        Select Container Type:
        <select name="select" required>
            <option value="LCL">LCL</option>
            <option value="FCL-20"> FCL-20</option>
            <option value="FCL-40"> FCL-40</option>
            <option value="sample">Sample</option>
            <!-- Add more options as needed -->
        </select><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>