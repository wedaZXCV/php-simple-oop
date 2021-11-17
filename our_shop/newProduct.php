<?php 
  require_once "includes/product.inc.php";
  require_once "includes/productPage.inc.php";
  echo"
  <h1>Successfully change to new product page    </h1>
  ";
  // Still require to give server information for connecting purpose
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";
  $prdPage = new ProductPage($dbhost, $dbuser, $dbpass, $db);
  $prdPage->loadAddNewPrdPage();
  if(!isset($_POST["name"]) && !isset($_POST["price"]) && !isset($_POST["qtt"])){
    
  } else{
    $productIns = new Product(1, $_POST["name"], $_POST["price"], $_POST["qtt"], $prdPage);
    $productIns->addNewProduct();
  }
  





?>