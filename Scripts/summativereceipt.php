<?php
session_start();

$file = "../Data/wallet.json";
$json = json_decode(file_get_contents($file), true);
$csvFile = "../Data/login.csv";
$csv = array_map('str_getcsv', file($csvFile));
$backend = "../Data/backend.json";
$backendJson = json_decode(file_get_contents($backend), true);
$money = $backendJson["moneySupply"];

foreach ($csv as $row) {
    if ($row[0] == $_SESSION['id']) {
        $pending = $row[6];
        break;
    }
}

$max_coins = $json[$_SESSION["id"]]["coins"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit-type'])) {
        $submitType = $_POST['submit-type'];
        
        if ($submitType === 'selected') {
            $input = $_POST['input-num'];
            $input = intval($input);
            if ($pending == 0) {
                // -= input from max coins and add to pending and update wallet.json and login.csv
                $max_coins -= $input;
                $pending += $input;
                $json[$_SESSION["id"]]["coins"] = $max_coins;
                
                // Update the $csv array with the new pending value
                foreach ($csv as &$row) {
                    if ($row[0] == $_SESSION['id']) {
                        $row[6] = $pending;
                        break;
                    }
                }
                unset($row); // Unset the reference to the last element
                
                // Write the updated $csv array back to the CSV file
                $fp = fopen($csvFile, "w");
                foreach ($csv as $row) {
                    fputcsv($fp, $row);
                }
                fclose($fp);
                
                // Update the wallet.json file
                file_put_contents($file, json_encode($json));

                $money -= $input;
                file_put_contents($backend, json_encode(array("moneySupply" => $money)));
                
                // header("Location: ../StudentPanel.php");
                echo '<script type="text/JavaScript">  
                          alert("You have successfully submitted ' . $input . ' MooreCoins! Please wait for your teacher to approve them.");
                          window.location.href="../StudentPanel.php";
                      </script>';
            } else {
                echo '<script type="text/JavaScript">  
                          alert("You have already submitted MooreCoins! Please wait for your teacher to approve them.");
                          window.location.href="../StudentPanel.php";
                      </script>';
            }
        } elseif ($submitType === 'all') {
            if ($pending == 0) {
                // -= input from max coins and add to pending and update wallet.json and login.csv
                $pending += $max_coins;
                $json[$_SESSION["id"]]["coins"] = 0;
                
                // Update the $csv array with the new pending value
                foreach ($csv as &$row) {
                    if ($row[0] == $_SESSION['id']) {
                        $row[6] = $pending;
                        break;
                    }
                }
                unset($row); // Unset the reference to the last element
                
                // Write the updated $csv array back to the CSV file
                $fp = fopen($csvFile, "w");
                foreach ($csv as $row) {
                    fputcsv($fp, $row);
                }
                fclose($fp);
                
                // Update the wallet.json file
                file_put_contents($file, json_encode($json));

                $backendJson["moneySupply"] -= $max_coins;
                file_put_contents($backend, json_encode($backendJson["moneySupply"]));
                
                // header("Location: ../StudentPanel.php");
                echo '<script type="text/JavaScript">  
                          alert("You have successfully submitted all of your MooreCoins! Please wait for your teacher to approve them.");
                          window.location.href="../StudentPanel.php";
                      </script>';
            } else {
                echo '<script type="text/JavaScript">  
                          alert("You have already submitted MooreCoins! Please wait for your teacher to approve them.");
                          window.location.href="../StudentPanel.php";
                      </script>';
            }
        }
    }
}
?>
