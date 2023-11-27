<?php
isset($_POST["feedback"]) ? $feedback = $_POST["feedback"] : $feedback = "";
isset($_POST["name"]) ? $name = $_POST["name"] : $name = "";

$feedbackFile = fopen("../Data/feedbackList.csv", "a");
fwrite($feedbackFile, $name . "," . $feedback . "\n");
fclose($feedbackFile);
echo "<script>alert('Successfully submitted feedback!');window.location.href = '../Feedback.php';</script>";
?>