<!DOCTYPE html>
<html>
    <head>
        <title>MooreCoin - Home</title>

        <meta charset="utf-8">

        <link href="./CSS/style.css" rel="stylesheet" type="text/css">

        <link rel="icon" type="image/x-icon" href="./Images/favicon.png">

        <meta name="viewport" content="width=device-width">
    </head>

    <body>
        <div class="header">
            <img src="./Images/favicon.png" alt="favicon" width="125" id="coin">
            <h1>MooreCoin</h1>
        </div>

        <div class="container">
            <center><h1 id="text">Signin / Register</h1></center>
            <form action="./Scripts/redirect.php" method="post" autocomplete="on" class="signin-register">
                <p><input type="text" name="id" placeholder="Student ID (Required)" maxlength="8" required /></p>
                <p><input type="text" name="name" placeholder="Full Name (Required on register)" /></p>
                <p><input type="number" name="hour" placeholder="Class Hour (Required on register)" min="1" max="6" /></p>
                <p><input type="password" name="age" placeholder="Password (Required)" minlength="8" required /></p>

                <p><input type="submit" style="align-self: center;" /></p>
            </form>
        </div>

        <div class="footer">
            <p><a href="https://github.com/noahlikesvr/MooreCoin" class="source-code" target="_blank">Source Code</a></p>
            <p><a href="Credits.php" class="credits">Credits</a></p>

            <p>MooreLess &copy; 2023</p>
        </div>
        
        <audio id="soundEffect"> 
            <source src="./Sounds/pop.mp3" type="audio/mpeg"> 
            Your browser does not support the audio element. 
        </audio>
        <script src="./Secrets/oneko.js"></script>
    </body>
</html>
