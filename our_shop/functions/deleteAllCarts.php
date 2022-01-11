<?php 
  require_once "../includes/mainCartPage.inc.php";
  require_once "../includes/mainCart.inc.php";
  
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";

  if(isset($_POST["delete"])){
    //do the delete all query here
    $mainPage = new MainCartPage($dbhost, $dbuser, $dbpass, $db);
    $cartIns = new MainCart($mainPage);
    $conn = $cartIns->connectdb();
    $cartIns->deleteAllCarts($conn);
    echo "There is no currently cart available.";
    $cartIns->closedb($conn);
  }else{
    echo "Something must be an error within the delete mechanism";
  }








?>