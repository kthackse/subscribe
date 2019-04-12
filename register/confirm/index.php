<?php
session_start();

require "../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create("../../");
$dotenv->load();

$code = "";
if(isset($_GET["code"])){
    $code = $_GET["code"];
}

if($code == ""){
    $_SESSION["status"] = "code";
    header("Location: ../../");
    die();
}

$conn = new mysqli(getenv('DB_SERVER'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
if($conn->connect_error){
    $_SESSION["status"] = "database";
    header("Location: ../../");
    die();
}

$sql = "SELECT * FROM confirmed WHERE hash = '" . $code . "';";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $_SESSION["status"] = "confirmed";
    $conn->close();
    header("Location: ../../");
    die();
}

$sql = "SELECT * FROM registered WHERE hash = '" . $code . "';";
$result = $conn->query($sql);
if($result->num_rows == 0){
    $_SESSION["status"] = "code";
    $conn->close();
    header("Location: ../../");
    die();
}

$result = $result->fetch_assoc();

$sql = "INSERT INTO confirmed (email, hash, created)
VALUES ('" . $result["email"] . "', '" . $result["hash"] . "', '" . $result["created"] . "');";

if($conn->query($sql) !== TRUE){
    $_SESSION["status"] = "database";
    $conn->close();
    header("Location: ../../");
    die();
}

$sql = "DELETE FROM registered WHERE email = '" . $result["email"] . "';";

if($conn->query($sql) !== TRUE){
    $_SESSION["status"] = "database";
    $conn->close();
    header("Location: ../../");
    die();
}

$conn->close();

$_SESSION["status"] = "activated";
header("Location: ../../");
die();
?>

