<?php
session_start();

if (isset($_POST["email"]) && isset($_POST["pwd"])) {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    
    $data = array("email" => $email, "name" => $name, "password" => $pwd);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/teacher/login");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 400) {
        header("Location: ../teacherlogin.php?error=Invalid email or password");
        exit();
    } else {
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $pwd;
        header("Location: ../teacher.php");
        exit();
    }
}