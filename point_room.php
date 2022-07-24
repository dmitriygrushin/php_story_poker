<?php 
define("ROOM_ID", $_GET['room_id']);
echo "room_id:" . constant("ROOM_ID");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5/dist/sketchy/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="http://code.createjs.com/easeljs-0.6.1.min.js"></script>

    <title>Get To The Point</title>
</head>
<body>
    <h1>Get To The Point</h1> 
    <br>
    <form action="" method="GET" id="rating-form">
        <label for="message"></label>
        <input type="text" id="message" name="message" placeholder="Type your message here">
        <input type="submit" value="Send">
    </form>

    <form action="" method="GET" id="evaluate-ratings-form">
        <input type="submit" value="Send">
    </form>

    <div>
        <ul id="user-list"></ul>
    </div>

    <div class="rate-buttons">
        <div class="container">
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:green">1</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:lightgreen">2</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:palegreen">3</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:orange">4</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:coral">5</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:tomato">6</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:orangered">7</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:crimson">8</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:firebrick">9</button></div>
                <div class="col-sm"><button class="btn btn-primary btn-lg w-100 h-100" style="background-color:darkred">10</button></div>
                <div class="col-sm"></div>
            </div>
        </div>
    </div>

    <canvas id="myCanvas" width="350" height="350"></canvas>

</body>
    <script src="public/javascripts/point_room.js"></script>
</html>

