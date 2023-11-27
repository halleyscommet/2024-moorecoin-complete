<?php
// session_start();

// $file = "Data/wallet.json";
// $json = json_decode(file_get_contents($file), true);
// $settings = "Data/backend.json";
// $jason = json_decode(file_get_contents($settings), true);

// $scenario = json_decode(file_get_contents("Data/scenario.json"), true);
// $date = date("z") + 1;
// $weekday = date("D");

// if ((abs($date - $jason["refreshDate"])) >= 7 && $scenario["weekday"] != $jason["refreshDay"]) {
//     $jason["refreshDay"] = $weekday;
//     $jason["refreshDate"] = $date;
//     $jason["scenario"] = rand(1, 5);
// } else {
//     $jason["refreshDay"] = $weekday;
// }

// $er = $scenario[strval($jason["scenario"])]["er"];
// $ir = $scenario[strval($jason["scenario"])]["ir"];
// $headline = $scenario[strval($jason["scenario"])]["scenario"];

session_start();

$file = "Data/wallet.json";
$json = json_decode(file_get_contents($file), true);
$settings = "Data/backend.json";
$jason = json_decode(file_get_contents($settings), true);
$csv = array_map('str_getcsv', file("Data/login.csv"));
$bond = json_decode(file_get_contents("Data/bonds.json"), true);
$scenario = json_decode(file_get_contents("Data/scenario.json"), true);
$date = date("z") + 1;
$weekday = date("D");
$er = $scenario[strval($jason["scenario"])]["er"];
$ir = $scenario[strval($jason["scenario"])]["ir"];
$headline = $scenario[strval($jason["scenario"])]["scenario"];
$feedbackFile = "Data/feedbackList.csv";
$feedback = array_map('str_getcsv', file($feedbackFile));

foreach ($csv as $row) {
    if ($row[0] == $_SESSION["id"]) {
        $studentName = $row[4];
    }
}

if (is_null($json[$_SESSION["id"]])) {
    $coins = 1.0;
    $jason["moneySupply"] += 1.0;
    $json[$_SESSION["id"]] = array("coins" => $coins);
    file_put_contents($file, json_encode($json));
    file_put_contents($settings, json_encode($jason));
    header("Refresh:0");
}

if ((abs($date - $jason["refreshDate"])) >= 7 && $scenario["weekday"] != $jason["refreshDay"]) {
    $jason["refreshDay"] = $weekday;
    $jason["refreshDate"] = $date;
    $jason["scenario"] = rand(1, 5);
} else {
    $jason["refreshDay"] = $weekday;
}

$money = floatval($jason["moneySupply"]);
// $jason["exchangeRate"] = round(((pow($money, 3)) / 16464000) - ((pow($money, 2) * 3) / 78400) + ($money / 1680) + (5 / 2), 3) + $er;
// $jason["exchangeRate"] = round(($jason["exchangeRate"] / 4.0), 3);
// $jason["exchangeRate"] = round(((($money ** 3) / 16464000) - ((3 * ($money ** 2)) / 78400) + ($money / 1680) + (5 / 2) + $er)/4, 3);
$jason["interestRate"] = round((91.0 / (3.0 * pow($money, 1 / 2))), 3) + $ir;
$jason["interestRate"] = round(($jason["interestRate"] / 3.0), 3);

file_put_contents($file, json_encode($json));
file_put_contents($settings, json_encode($jason));
file_put_contents("Data/bonds.json", json_encode($bond));
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

        <div class="content">
            <center>
                <h1 id="text">Welcome, <span class="orange"><?php echo $studentName ?></span>!</h1><br>
                <div class="balance-container">
                    <div class="balance-item">
                        <p>MooreCoins</p>
                        <span class="orange"><?php echo $json[$_SESSION["id"]]["coins"]; ?></span>
                    </div>
                    <div class="balance-item">
                        <p>&asymp;<p>
                    </div>
                    <div class="balance-item">
                        <p>Extra Credit Points</p>
                        <span class="orange"><?php echo ($jason["exchangeRate"]) * $json[$_SESSION["id"]]["coins"]; ?></span>
                    </div>
                </div>

                <p class="exchange-rate">1 &asymp; <?php echo $jason["exchangeRate"]; ?></p>

                <?php
                $selectedCoins = 1;
                ?>

                <form action="Scripts/summativereceipt.php" method="post">
                    <input type="number" min="1" max="<?php echo $json[$_SESSION["id"]]["coins"]; ?>" class="input-num exchange-btn" value="1" id="input-num" name="input-num">
                    <button class="btn exchange-btn" type="submit" name="submit-type" value="selected">Submit Selected</button>
                    <br><br>

                    <button class="btn exchange-btn" id="allbutton" type="submit" name="submit-type" value="all">Submit All (<span id="available-coins"><?php echo $json[$_SESSION["id"]]["coins"]; ?></span>)</button>
                </form>

                <div class="breaking-news">
                    <h1 id="text">BREAKING NEWS: <?php echo $headline ?></h1>
                </div>
            </center>

            <?php
            if ($_SESSION["id"] == 20035656 || $_SESSION["id"] == 20029686) {
                echo "<center><h1 id='text'>Feedback:</h1>";
                foreach ($feedback as $row) {
                    echo "
                        <p class='feedback-thingy'>" . $row[0] . " - " . $row[1] ."</p>
                    </center>";
                }
            }
            ?>
        </div>

        <div class="footer">
            <p><a href="https://github.com/noahlikesvr/MooreCoin" target="_blank" class="source-code">Source Code</a></p>
            <p><a href="Feedback.php" class="feedback">Feedback</a></p>
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