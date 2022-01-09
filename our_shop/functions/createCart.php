<?php 
  require_once "../includes/mainCartPage.inc.php";
  require_once "../includes/mainCart.inc.php";
  
  //add new Cart based on the name given
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";

  if(isset($_POST["cartname"])){
    $mainPage = new MainCartPage($dbhost, $dbuser, $dbpass, $db);
    $cartIns = new MainCart($mainPage);
    $conn = $cartIns->connectdb();
    if(isset($_POST["cartnote"])){
      $cartIns->addNewCart($conn, $_POST["cartname"], $_POST["cartnote"]);
    }else {
      $cartIns->addNewCart($conn, $_POST["cartname"]);
    }
    // THIS IS THE ONLY RESPONSE
    // retrieve all cart and display immediately
    $cartIns->showCarts($conn);
    $cartIns->closedb($conn);

  }else{
    echo "
    <p>
      You have reached the createCart.php at functions folder!
      But the POST was not well received yet.
    </p>";
  }









?>