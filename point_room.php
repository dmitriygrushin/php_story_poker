<?php 
define("ROOM_ID", $_GET['room_id']);
echo "room_id: " . constant("ROOM_ID");
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

    <title>Story Bluff</title>
</head>
<body style="background-color:#f7f7f9;">
    <h1 class="text-center display-1">Story Bluff</h1> 
    <div class="container border border-3 border-primary rounded-3">
        <div class="row">
            <div class="col-sm-2 border-end border-3 border-primary rounded-3">
                <div>
                    <ul id="user-list"></ul>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="rate-buttons">
                    <div class="row">
                        <h2 class="text-center">-------------------- Point(s)  --------------------</h2>
                        <div class="col-sm"></div>
                        <div class="col-sm"><button id="1" class="btn btn-primary w-100 h-100" style="background-color:green">1</button></div>
                        <div class="col-sm"><button id="2"class="btn btn-primary w-100 h-100" style="background-color:lightgreen">2</button></div>
                        <div class="col-sm"><button id="3" class="btn btn-primary w-100 h-100" style="background-color:palegreen">3</button></div>
                        <div class="col-sm"><button id="4" class="btn btn-primary w-100 h-100" style="background-color:orange">4</button></div>
                        <div class="col-sm"><button id="5" class="btn btn-primary w-100 h-100" style="background-color:coral">5</button></div>
                        <div class="col-sm"><button id="6" class="btn btn-primary w-100 h-100" style="background-color:tomato">6</button></div>
                        <div class="col-sm"><button id="7" class="btn btn-primary w-100 h-100" style="background-color:orangered">7</button></div>
                        <div class="col-sm"><button id="8" class="btn btn-primary w-100 h-100" style="background-color:crimson">8</button></div>
                        <div class="col-sm"><button id="9" class="btn btn-primary w-100 h-100" style="background-color:firebrick">9</button></div>
                        <div class="col-sm"><button id="10" class="btn btn-primary btn-lg w-100 h-100" style="background-color:darkred">10</button></div>
                        <div class="col-sm"></div>
                    </div>
                    <div class="row m-5">
                        <div class="col-sm"></div>
                        <div class="col-sm"><button id="15" class="btn btn-primary w-100 h-100" style="background-color:lavender">15</button></div>
                        <div class="col-sm"><button id="20"class="btn btn-primary w-100 h-100" style="background-color: thistle">20</button></div>
                        <div class="col-sm"><button id="25" class="btn btn-primary w-100 h-100" style="background-color:plum">25</button></div>
                        <div class="col-sm"><button id="30" class="btn btn-primary w-100 h-100" style="background-color:violet">30</button></div>
                        <div class="col-sm"><button id="40" class="btn btn-primary w-100 h-100" style="background-color:orchid">40</button></div>
                        <div class="col-sm"><button id="50" class="btn btn-primary w-100 h-100" style="background-color:fuchsia">50</button></div>
                        <div class="col-sm"><button id="60" class="btn btn-primary w-100 h-100" style="background-color:magenta">60</button></div>
                        <div class="col-sm"><button id="75" class="btn btn-primary w-100 h-100" style="background-color:mediumpurple">75</button></div>
                        <div class="col-sm"><button id="90" class="btn btn-primary w-100 h-100" style="background-color:purple">90</button></div>
                        <div class="col-sm"><button id="100" class="btn btn-primary w-100 h-100" style="background-color:indigo">100</button></div>
                        <div class="col-sm"></div>
                    </div>
                    <h2 class="text-center">---------------------------------------------------</h2>
                </div>

                <div class="container">
                    <div class="text-center">
                        <canvas id="myCanvas" width="350" height="350"></canvas>
                    </div>
                    <div class="text-center">
                        <form action="" method="GET" id="evaluate-ratings-form">
                            <input class="btn btn-secondary btn-lg w-100" type="submit" value="Get Results!">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
    <script src="public/javascripts/point_room.js"></script>
</html>

