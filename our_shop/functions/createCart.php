<?php 
  require_once "../includes/mainCartPage.inc.php";
  require_once "../includes/mainCart.inc.php";
  
  //add new Cart based on the name given
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";

  if(isset($_POST["cartname"])){
    echo "
    <p>
      successfully got POST cartname! The cart name is ".$_POST["cartname"]."
    </p>
    ";
    $mainPage = new MainCartPage($dbhost, $dbuser, $dbpass, $db);
    $cartIns = new MainCart($mainPage);
    $cartIns->addNewCart($_POST["cartname"]);
  }else{
    echo "
    <p>
      You have reached the createCart.php at functions folder!
      But the POST was not well received yet.
    </p>";
  }









?>