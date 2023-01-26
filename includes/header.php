<?php
require_once("./includes/config.php");
require_once("./includes/classes/PreviewProvider.php");
require_once("./includes/classes/CategoryContainers.php");
require_once("./includes/classes/Entity.php");
require_once("./includes/classes/EntityProvider.php");
require_once("./includes/classes/ErrorMessage.php");
require_once("./includes/classes/SeasonProvider.php");
require_once("./includes/classes/Season.php");
require_once("./includes/classes/Video.php");
require_once("./includes/classes/VideoProvider.php");
require_once("./includes/classes/User.php");

// If not logged in
if (!isset($_SESSION["userLoggedIn"])) {
    header("Location:./register.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <link rel="stylesheet" href="./assets/style/style.css">
    <title>Welcome to Netflix</title>
</head>

<body>

    <div class='wrapper'>

<?php 
if(!isset($hideNav)) {
    include_once("./includes/navBar.php");
}
?>