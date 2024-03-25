<?php
session_start();

if ($_SESSION["email"] == null || $_SESSION["password"] == null) {
    header("Location: ../teachersignin.php");
    exit();
}

$email = $_SESSION["email"];
$pwd = $_SESSION["password"];

$data = array("email" => $email, "password" => $pwd);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/teacher/get/name");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode == 200) {
    $response = json_decode($response, true);
    $name = $response["name"];
} else {
    header("Location: ?error=Failed to get name");
    exit();
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/teacher/get/classes");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$response = json_decode($response, true); // Decode the JSON response
$classes = $response["classes"];

if (empty($classes)) {
    header("Location: firstclass.php");
    exit();
} else {
    $class_name = $classes;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>MooreCoin</title>

        <link rel="stylesheet" href="CSS/style.css">

        <link rel="icon" type="image/x-icon" href="Images/favicon.png">
    </head>

    <body>
        <div id="blurry-circle"></div>
        <script src="JS/circle.js"></script>
        <script src="JS/error.js"></script>
        <script src="JS/success.js"></script>

        <div class="center">
            <h1>Welcome, <span class="moorecoin"><?php echo $name; ?></span>!</h1>
            <p>Manage your classes:<p>
            <div class="class-list">
                <?php
                foreach ($class_name as $class) {
                    $data = array("email" => $email, "password" => $pwd, "class_name" => $class);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/teacher/get/class/code");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

                    $response = curl_exec($ch);
                    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    $response = json_decode($response, true); // Decode the JSON response
                    $class_code = $response["class_code"];

                    echo "
                        <a href=\"manageclass?code=" . $class_code . "\"><button class=\"button-outline\">" . $class . "</button></a>
                        <br><br>
                    ";
                }
                ?>
            </div>
        </div>
    </body>
</html>