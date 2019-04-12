<?php
session_start();

include "../config/config.php";

$email = "";
if(isset($_POST["email"])){
    $email = $_POST["email"];
}

$policies = "";
if(isset($_POST["policies"])){
    $policies = $_POST["policies"];
}

if($email == ""){
    $_SESSION["status"] = "email";
    header("Location: ../");
    die();
}
else if($policies != "accept"){
    $_SESSION["status"] = "checkbox";
    header("Location: ../");
    die();
}
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION["status"] = "format";
    header("Location: ../");
    die();
}

$hash = bin2hex(random_bytes(32));

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    $_SESSION["status"] = "database";
    header("Location: ../");
    die();
}

$sql = "SELECT * FROM registered WHERE email = '" . $email . "';";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $_SESSION["status"] = "registered";
    $conn->close();
    header("Location: ../");
    die();
}

$sql = "SELECT * FROM confirmed WHERE email = '" . $email . "';";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $_SESSION["status"] = "confirmed";
    $conn->close();
    header("Location: ../");
    die();
}

$sql = "INSERT INTO registered (email, hash)
VALUES ('" . $email . "', '" . $hash . "');";

if($conn->query($sql) !== TRUE){
    $_SESSION["status"] = "database";
    $conn->close();
    header("Location: ../");
    die();
}

$conn->close();

$subject = 'KTHack 2020 - Subscribe';
$headers = 'From: noreply@kthack.com' . "\r\n" .
    'Reply-To: contact@kthack.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$template = file_get_contents("templates/confirm.html");
$template = str_replace('{{confirm_hash}}', $hash, $template);

mail($email, $subject, $template, $headers);

$_SESSION["status"] = "done";
header("Location: ../");
die();
?>

