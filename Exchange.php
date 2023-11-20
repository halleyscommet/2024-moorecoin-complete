<?php
session_start();

$file = "Data/wallet.json";
$json = json_decode(file_get_contents($file), true);
$settings = "Data/backend.json";
$jason = json_decode(file_get_contents($settings), true);

$scenario = json_decode(file_get_contents("Data/scenario.json"), true);
$date = date("z") + 1;
$weekday = date("D");

if ((abs($date - $jason["refreshDate"])) >= 7 && $scenario["weekday"] != $jason["refreshDay"]) {
    $jason["refreshDay"] = $weekday;
    $jason["refreshDate"] = $date;
    $jason["scenario"] = rand(1, 5);
} else {
    $jason["refreshDay"] = $weekday;
}

$er = $scenario[strval($jason["scenario"])]["er"];
$ir = $scenario[strval($jason["scenario"])]["ir"];
$headline = $scenario[strval($jason["scenario"])]["scenario"];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>MooreCoin - Exchange</title>

        <meta charset="utf-8">

        <link href="./CSS/style.css" rel="stylesheet" type="text/css">

        <link rel="icon" type="image/x-icon" href="./Images/favicon.png">

        <meta name="viewport" content="width=device-width">
    </head>

    <body>
        <div class="header">
            <img src="./Images/favicon.png" alt="favicon" width="125" id="coin">
            <h1>Exchange</h1>
        </div>

        <center>
            <h1 id="text">BREAKING: <?php echo $headline ?></h1>

            <?php
            $selectedCoins = 1;
            ?>

            <form action="Scripts/summativereceipt.php" method="post">
                <input type="number" min="1" max="<?php echo $json[$_SESSION["id"]]["coins"]; ?>" class="input-num" value="1" id="input-num" name="input-num">
                <button class="btn" type="submit" name="submit-type" value="selected">Submit Selected</button>
                <br><br>

                <button class="btn" id="allbutton" type="submit" name="submit-type" value="all">Submit All (<span id="available-coins"><?php echo $json[$_SESSION["id"]]["coins"]; ?></span>)</button>
            </form>
        </center>

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