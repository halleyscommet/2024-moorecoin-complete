<?php
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
}

if ((abs($date - $jason["refreshDate"])) >= 7 && $scenario["weekday"] != $jason["refreshDay"]) {
    $jason["refreshDay"] = $weekday;
    $jason["refreshDate"] = $date;
    $jason["scenario"] = rand(1, 5);
} else {
    $jason["refreshDay"] = $weekday;
}

$money = floatval($jason["moneySupply"]);
$jason["exchangeRate"] = round(((pow($money, 3)) / 16464000) - ((pow($money, 2) * 3) / 78400) + ($money / 1680) + (5 / 2), 3) + $er;
$jason["exchangeRate"] = round(($jason["exchangeRate"] / 4.0), 3);
$jason["interestRate"] = round((91.0 / (3.0 * pow($money, 1 / 2))), 3) + $ir;
$jason["interestRate"] = round(($jason["interestRate"] / 3.0), 3);

file_put_contents($file, json_encode($json));
file_put_contents($settings, json_encode($jason));
file_put_contents("Data/bonds.json", json_encode($bond));

$er = $jason["exchangeRate"];

if ($_SESSION['id'] != "admin") {
    header("Location: Wallet.php");
    exit();
}

foreach ($csv as $row) {
    if ($row[0] == $_SESSION['id'] && $row[0] != "admin") {
        $studentName = $row[4];
        $studentHour = $row[5];
        $pending = $row[6];
        break;
    }
}

$walletData = json_decode(file_get_contents('Data/wallet.json'), true);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>MooreCoin - Admin Panel</title>

        <meta charset="utf-8">

        <link href="./CSS/adminpanel.css" rel="stylesheet" type="text/css">

        <link href="./CSS/style.css" rel="stylesheet" type="text/css">

        <link rel="icon" type="image/x-icon" href="./Images/favicon.png">

        <meta name="viewport" content="width=device-width">
    </head>

    <body>
        <div class="header">
            <img src="./Images/favicon.png" alt="favicon" width="125" id="coin">
            <h1>Admin Panel</h1>
        </div>

        <div class="container">
            <center><h1 id="text">Student MooreCoins</h1></center>
        </div>
        <div class="content">
            <div id="coin-actions">
                <center>
                    <div class="container">
                        <form action="Scripts/updatecoinshour.php" method="post" class="coin-edit">
                            <select name="hr">
                                <option value="1">1st Hour</option>
                                <option value="2">2nd Hour</option>
                                <option value="3">3rd Hour</option>
                                <option value="4">4th Hour</option>
                                <option value="5">5th Hour</option>
                                <option value="6">6th Hour</option>
                            </select>
                            <input name="inputB" type="number" class="coin-edit-input" value="0">
                            <button name="btn" class="coin-edit-confirm" type="submit">Give MooreCoins</button>
                        </form>
                    </div>

                    <table>
                        <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Hour #</th>
                            <th>MooreCoins</th>
                            <th>+ / -</th>
                            <th>!</th>
                        </tr>
                        <?php
                        foreach ($walletData as $studentId => $walletInfo) {
                            if ($studentId != "admin") {
                                foreach ($csv as $row) {
                                    if ($row[0] == $studentId && $row[0] != "admin") {
                                        $studentId = $row[0];
                                        $studentName = $row[4];
                                        $studentHour = $row[5];
                                        $pending = $row[6];
                                        break;
                                    }
                                }
                                echo '<tr>';
                                echo '<th>' . $studentName . '</th>';
                                echo '<th>' . $studentId . '</th>';
                                echo '<th>' . $studentHour . '</th>';
                                echo '<th id="moorecoins-' . $studentId . '">' . $walletInfo['coins'] . '</th>';
                                echo '<th>
                                    <form class="coin-edit" method="post" action="Scripts/updatecoins.php">
                                        <input name="inputB" type="number" class="coin-edit-input" value="0">
                                        <button name="btn" class="coin-edit-confirm" value="' . $studentId . '" type="submit">Confirm</button>
                                    </form>
                                </th>';
                                if ($pending > 0) {echo '<th>
                                        <form class="coin-edit" action="Scripts/clear.php" method="post">
                                            <button name="!" class="coin-edit-confirm" type="button" onclick=\'alert("' . $studentName . ' submitted ' . $pending .' MooreCoins. (' . $er*$pending . ' EC Points)");\'>Alert</button>
                                            <button name="copy" class="coin-edit-confirm" type="button" onclick=\'navigator.clipboard.writeText("' . $er*$pending . '");alert("Copied ' . $er*$pending . ' to clipboard.")\'>Copy</button>
                                            <button name="clear" class="coin-edit-confirm" value="' . $studentId . '" type="submit">🧹</button>
                                        </form>
                                    </th>';}
                                echo '</tr>';
                            }
                        }
                        ?>
                    </table>
                </center>
            </div>
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