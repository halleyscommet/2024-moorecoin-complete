<?php
session_start();

if ($_SESSION["email"] == null || $_SESSION["password"] == null) {
    header("Location: ../teachersignin.php");
    exit();
} else {
    if (isset($_POST["pwd"]) && isset($_POST["class_name"])) {
        $email = $_SESSION["email"];
        $pwd = $_SESSION["password"];
        $enteredpwd = $_POST["pwd"];
        $class_name = $_POST["class_name"];
        $class_code = substr(md5($class_name), 0, 6);

        if ($enteredpwd != $pwd) {
            header("Location: ../teacher.php#createclass?error=Incorrect Password");
            exit();
        } else {
            $data = array("email" => $email, "password" => $enteredpwd, "class_name" => $class_name, "class_code" => $class_code);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/teacher/create/class");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode == 201) {
                header("Location: ../teacher.php?success=Class Created!");
                exit();
            } else {
                header("Location: ../teacher.php#createclass?error=Class Creation Failed");
                exit();
            }
        }
    }
}