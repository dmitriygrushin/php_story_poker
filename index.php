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
<body class="d-flex flex-column min-vh-100" style="background-color:#f7f7f9;">
 <div class="row">
    <div class="w-50 mx-auto mt-5">
        <h1 class="display-1 text-center">----- Story Bluff -----</h1> 
        <br>
        <form action="./point_room.php" method="GET">
            <div class="text-center"> 
                <label class="display-3" for="username"><u>Username</u></label>
                <input class ="form-control form-control-lg" type="text" id="username" name="username" placeholder="Type your username here" required>
            </div>
            <?php if (isset($_GET['joining'])) { ?>
                <div id="room_id_input">
                    <label for="room_id"></label>
                    <input value="<?php echo $_GET['joining']; ?>" type="text" name="room_id" placeholder="the room_id you're joining is in this input" readonly hidden>
                </div>
                <div class="text-center">
                    <input class="btn btn-lg btn-info" type="submit" value="Join Room">
                </div>
            <?php } else { ?>
                <div id="room_id_input">
                    <label for="room_id"></label>
                    <input type="text" id="room_id" name="room_id" placeholder="your room id is in this input" readonly hidden>
                </div>
                <input type="hidden" name="moderator" value="true">
                <div class="text-center">
                    <input class="btn btn-lg btn-info" type="submit" value="Create Room">
                </div>
            <?php } ?>

        </form>
    </div>
  </div>

<footer class="bg-light text-center text-lg-start mt-auto">
  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2022 Copyright: Dmitriy Grushin
  </div>
  <!-- Copyright -->
</footer>
</body>
    <script src="public/javascripts/index.js"></script>
</html>