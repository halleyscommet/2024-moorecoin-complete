<?php
session_start();

$file = "../Data/wallet.json";
$json = json_decode(file_get_contents($file), true);
$csvFile = "../Data/login.csv";
$csv = array_map('str_getcsv', file($csvFile));
$backend = "../Data/backend.json";
$backendJson = json_decode(file_get_contents($backend), true);
$money = $backendJson["moneySupply"];

if ($_SESSION["id"] != "admin") {
    header("Location: ../StudentPanel.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST["btn"]) && !empty($_POST["inputB"])) {
            $studentId = $_POST["btn"];
            $mooreCoins2Add = $_POST["inputB"];
    
            $json[$studentId]["coins"] += $mooreCoins2Add;
            $backendJson["moneySupply"] += $mooreCoins2Add;
    
            foreach ($csv as $row) {
                if ($row[0] == $studentId) {
                    file_put_contents($backend, json_encode($backendJson));
                    file_put_contents($file, json_encode($json));
                }
            }
    
            header("Location: ../AdminPanel.php");
        }
    }
}
