<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <script>
        // Redirect after 1 second (1000 milliseconds)
        setTimeout(function() {
            window.location.href = "{{ $redirectUrl }}";
        }, 1000);
    </script>
</head>
<body>
<p>Redirecting you in 1 second...</p>
</body>
</html>
