
<?php
        // MySQL database credentials
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'task_management';

        // Create connection
        $conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

                // Delete all data from the plannew table
                $deletePlannewSql = "DELETE FROM copied_work";
                $conn->query($deletePlannewSql);

          

                // Commit the transaction if all queries are successful
                $conn->commit();

                header("Location: plannew34R.php");
                exit();
        ?>
    </div>
</body>
</html>