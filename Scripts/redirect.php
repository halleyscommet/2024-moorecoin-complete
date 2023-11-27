<?php
// Start the session
session_start();
//Storing 
$id = $_POST['id'];
$name = $_POST['name'];
$hour = $_POST['hour'];
$password = $_POST['age'];
$email = $id . "@brightonk12.com";
$file = "../Data/login.csv";
$settings = "Data/backend.json";
$jason = json_decode(file_get_contents($settings), true);

$csv = array_map('str_getcsv', file($file));
$ids = array_column($csv, 0);

if (!in_array($id, $ids)) {
    // Generate a random salt
    $salt = bin2hex(random_bytes(16));
    // Hash the password with the salt using SHA-2
    $hash = hash('sha256', $password . $salt);
    $csv[] = array($id, $email, $hash, $salt, $name, $hour, 0);
    $fp = fopen($file, 'w');
    foreach ($csv as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
    $_SESSION["id"] = $id;
}

//This block is for redirecting to a wallet if they have the right credentials, otherwise, no
$csv = array_map('str_getcsv', file($file));
foreach ($csv as $row) {
    if ($row[0] == $id) {
        if ($id == "admin") {
            // Hash the password with the salt using SHA-2
            $hash = hash('sha256', $password . $row[3]);
            if ($hash == $row[2]) {
                header('Location: ../AdminPanel.php'); 
                $_SESSION["id"] = $id;
                exit;
            }
        } else {
            // Hash the password with the salt using SHA-2
            $hash = hash('sha256', $password . $row[3]);
            if ($hash == $row[2]) {
                header('Location: ../StudentPanel.php');
                //Store the id for the session so that we can show their wallet. 
                $_SESSION["id"] = $id;
                exit;
            }
        }
    }
}
header('Location: ../');
exit;
?>