<!DOCTYPE html>
<html>
    <head>
        <title>MooreCoin - Feedback</title>

        <meta charset="utf-8">

        <link href="./CSS/style.css" rel="stylesheet" type="text/css">

        <link rel="icon" type="image/x-icon" href="./Images/favicon.png">

        <meta name="viewport" content="width=device-width">
    </head>

    <body>
        <div class="header">
            <img src="./Images/favicon.png" alt="favicon" width="125" id="coin">
            <h1>Feedback</h1>
        </div>

        <center>
            <h1 id="text">Let us know what you have to say</h1>
        </center>

        <div class="content">
            <center>
                <form action="Scripts/feedback.php" method="post" class="signin-register2">
                    <input type="text" name="name" id="name" placeholder="Subject"><br>
                    <textarea name="feedback" id="feedback" cols="70" rows="20" placeholder="Enter your feedback here"></textarea><br>
                    <input type="submit" value="Submit" class="submit-btn">
                </form>
            </center>
        </div>

        <div class="footer">
            <p><a href="https://github.com/noahlikesvr/MooreCoin" target="_blank" class="source-code">Source Code</a></p>
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