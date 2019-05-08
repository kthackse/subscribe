<?php
session_start();

require "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create("../");
$dotenv->load();

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

$conn = new mysqli(getenv('DB_SERVER'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
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

$template = file_get_contents("templates/confirm.html");
$template = str_replace('{{confirm_hash}}', $hash, $template);

use SendGrid\Mail\Content;
use SendGrid\Mail\From;
use SendGrid\Mail\Mail;
use SendGrid\Mail\To;

$subject = "Confirm your email to subscribe for KTHack 2020!";
$fromEmail = "noreply@kthack.com";
$fromName = "KTHack";
$toEmail = $email;
$htmlContent = $template;

$from = new From($fromEmail, $fromName);
$to = new To($toEmail);

$content = new Content("text/html", $htmlContent);

$mail = new Mail($from, $to, $subject);
$mail->addContent($content);

$sg = new SendGrid(getenv('SENDGRID_KEY'));

$response = $sg->client->mail()->send()->post($mail);

if($response->statusCode() == 202){
    echo 'Mail sent!';
}
else{
    echo 'Mail not sent!';
}

$_SESSION["status"] = "done";
header("Location: ../");
die();
?>

