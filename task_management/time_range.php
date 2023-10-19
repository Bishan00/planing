
<!DOCTYPE html>
<html>
<head>
    <title>Retrieve Events</title>
</head>
<body>
    <h2>Retrieve Events</h2>
    <form action="compound.php" method="post">
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
