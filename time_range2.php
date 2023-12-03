
<!DOCTYPE html>
<html>
<head>
    <title>Retrieve Events</title>
</head>

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
            background-color: rgba(255, 255, 255, 0.8); /* Add a semi-transparent white background to the container */
            padding: 50px;
            border-radius: 20px; /* Add rounded corners to the container */
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
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Cantarell Bold', sans-serif;
        }

        input[type="submit"]:hover {
            background-color: #FFA726;
        }
    </style>
<body>
<div class="container">
    <h2>Retrieve Events</h2>
    <form action="new1.php" method="post">
        <label for="start_time">Start Date and Time:</label>
        <input type="datetime-local" id="start_time" name="start_time" required>
        <br><br>
        <label for="end_time">End Date and Time:</label>
        <input type="datetime-local" id="end_time" name="end_time" required>
        <br><br>
        <input type="submit" value="Retrieve Events">
    </form>
</body>
</html>
