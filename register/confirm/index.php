<?php
session_start();

require "../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create("../");
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

$sql = "SELECT * FROM registered WHERE hash = '" . $code . "';";
$result = $conn->query($sql);
if($result->num_rows == 0){
    $_SESSION["status"] = "code";
    $conn->close();
    header("Location: ../");
    die();
}

echo($result->fetch_assoc());
?>

