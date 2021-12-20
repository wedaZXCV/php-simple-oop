<?php 
  require_once "../includes/mainCartPage.inc.php";
  require_once "../includes/mainCart.inc.php";
  
  //add new Cart based on the name given
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";

  if(isset($_POST["name"])){
    $mainPage = new MainCartPage();
    $cartIns = new MainCart($mainPage);
    $cartIns->addNewCart($_POST["name"]);
  }









?>