<?php
session_start();

$file = "../Data/wallet.json";
$json = json_decode(file_get_contents($file), true);
$csvFile = "../Data/login.csv";
$csv = array_map('str_getcsv', file($csvFile));

if ($_SESSION["id"] != "admin") {
    header("Location: ../Wallet.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST["btn"]) && !empty($_POST["inputB"]) && isset($_POST["hr"])) {
            $hour = $_POST["hr"];
            $mooreCoins2Add = $_POST["inputB"];

            foreach ($csv as $row) {
                if ($row[5] == $hour) {
                    $id = $row[0];
                    $json[$id]["coins"] += $mooreCoins2Add;
                    file_put_contents($file, json_encode($json));
                }
                echo '<script>alert(\'' . $mooreCoins2Add . ' coin(s) added to hour ' . $hour . '.\'); window.location.href="../AdminPanel.php";</script>';
            }
        } else {
            header("Location: ../AdminPanel.php");
            exit();
        }
    }
}
