<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Greeting</title>
</head>
<body>
    <h1>Enter Your Name</h1>
    <form action="api.php" method="get">
        <label for="visitor_name">Name:</label>
        <input type="text" id="visitor_name" name="visitor_name" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>