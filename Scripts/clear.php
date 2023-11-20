<?php
session_start();

$file = "../Data/wallet.json";
$json = json_decode(file_get_contents($file), true);
$csvFile = "../Data/login.csv";
$csv = array_map('str_getcsv', file($csvFile));

if ($_SESSION['id'] != "admin") {
    header("Location: ../Wallet.php");
    exit();
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['clear'])) {
            foreach ($csv as &$row) {
                if ($row[0] == $_POST['clear']) {
                    $row[6] = 0;
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
    
            header("Location: ../AdminPanel.php");
        }
    }
}
?>