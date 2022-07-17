<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get To The Point</title>
</head>
<body>
    <h1>Make Your Point</h1> 
    <br>
    <form action="./point_room.php" method="GET">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Type your username here">

        <div id="room_id_input">
            <label for="room_id"></label>
            <input type="text" id="room_id" name="room_id" placeholder="Type your room id here" readonly hidden>
        </div>
        <input type="submit" value="Create Room">
    </form>
</body>
    <script src="public/javascripts/index.js"></script>
</html>