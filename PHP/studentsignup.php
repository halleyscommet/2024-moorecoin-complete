<?php
session_start();

if (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["pwd"]) && isset($_POST["cpwd"])) {
    $email = $_POST["id"];
    $name = $_POST["name"];
    $pwd = $_POST["pwd"];
    $cpwd = $_POST["cpwd"];

    if ($pwd != $cpwd) {
        header("Location: ../studentsignup.php?error=Passwords do not match");
        exit();
    } else {
        $data = array("id" => $id, "name" => $name, "password" => $pwd);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/student/signup");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode == 400) {
            header("Location: ../studentsignup.php?error=An error occurred.");
            exit();
        } else {
            $_SESSION["id"] = $id;
            $_SESSION["password"] = $pwd;
            header("Location: ../studentsignup.php");
            exit();
        }
    }
}