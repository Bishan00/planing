<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
    <script>
        // Specify the target page you want to redirect to
        var targetPage = "deleteall.php";
        
        // Set the time (in milliseconds) you want the delay before redirection
        var delayMilliseconds = 100; // Change this value to the desired delay
        
        // Function to perform the redirection
        function redirectToTargetPage() {
            window.location.href = targetPage;
        }
        
        // Call the redirectToTargetPage function after the delay
        setTimeout(redirectToTargetPage, delayMilliseconds);
    </script>
</head>

