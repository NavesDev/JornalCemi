<?php 
    session_start();
    if(!isset($_SESSION["userToken"])){
        header("location: reg_page.php");
    }
?>