<?php
session_start();

$json = file_get_contents('./Data/wallet.json');
$wallet = json_decode($json, true);
$id = $_SESSION['id'];

$mooreCoins = $wallet[$id]['coins'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MooreCoin - Shop</title>
        
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width">

        <link href="./CSS/style.css" rel="stylesheet" type="text/css">

        <link href="./CSS/shop.css" rel="stylesheet" type="text/css">

        <link rel="icon" type="image/x-icon" href="./Images/favicon.png">
    </head>

    <body>

        <div class="header">
            <img src="./Images/favicon.png" alt="favicon" width="125" id="coin">
            <h1>Shop</h1>
        </div>

        <div id="container">
            <center>
                <div id="content">
                    <h1 id="text">
                        Welcome to the Shop!<br>
                        You have <span class="orange"><?php echo $mooreCoins; if ($mooreCoins > 1) {echo "</span> MooreCoins";} else {echo "</span> MooreCoin";}; ?>.
                    </h1>

                    <div id="menu">
                        <h2>
                            <a href="?category=icons" class="category">Icons</a>
                             | 
                            <a href="?category=themes" class="category">Themes</a>
                            <br><br>
                        </h2>
                    </div>

                    <?php
                    $category = isset($_GET['category']) ? $_GET['category'] : "icons";

                    if ($category === 'icons') {
                        ?>
                        <h2>Icons</h2>
                        <?php
                    } elseif ($category === 'themes') {
                        ?>
                        <h2>Themes</h2>
                        <?php
                    }
                    ?>
                </div>
            </center>
        </div>

        <div class="footer">
            <p><a href="https://github.com/noahlikesvr/MooreCoin" class="source-code" target="_blank">Source Code</a></p>
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
