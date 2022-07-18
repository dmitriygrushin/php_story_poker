<?php 
define("GREETING", $_GET['room_id']);
echo "room_id:" . constant("GREETING");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get To The Point</title>
</head>
<body>
    <h1>Get To The Point</h1> 
    <br>
    <form action="" method="GET">
        <label for="message"></label>
        <input type="text" id="message" name="message" placeholder="Type your message here">
        <input type="submit" value="Send">
    </form>

    <div>
        <ul id="user-list"></ul>
    </div>


    <div>
        <ul id="chat"></ul>
    </div>
</body>
    <script src="public/javascripts/point_room.js"></script>
</html>

