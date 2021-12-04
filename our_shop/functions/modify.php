<?php
require_once "../includes/productPage.inc.php";
require_once "../includes/product.inc.php";

//delete the obtained id(s)
$dbhost = "localhost:3306";
$dbuser = "root";
$dbpass = "Hinterrollover7<3";
$db = "shopping";
$prdPage = new ProductPage($dbhost, $dbuser, $dbpass, $db);
$productIns = new Product($prdPage);

if(isset($_GET["name"])){
  echo "<h2>Modify Values for ".$_GET["name"]."</h2>";
}
echo "<br>";
if(isset($_GET["price"]) || isset($_GET["qtt"])){
  echo "
  <h3>Modify the price</h3>
  <h4>The price was ".$_GET["price"]."</h4>";
  echo "
  <form action=\"modify.php\" method=\"POST\">
    <input type=\"hidden\" name=\"id\" value=\"".$_GET["id"]."\">
    <input type=\"number\" name=\"price\" value=\"".$_GET["price"]."\">
  ";
  echo "
  <h3>Modify the quantity</h3>
  <h4>The Quantity was ".$_GET["qtt"]."</h4>";
  echo "
  <input type=\"number\" name=\"qtt\" value=\"".$_GET["qtt"]."\">
  <br>
  <button type=\"submit\">Save change</button>
  </form>
  ";
} else if(isset($_POST["price"]) && isset($_POST["qtt"])){
  //do push price and qtt data to database
  $productIns->modifyPriceQtt($_POST["price"], $_POST["qtt"], $_POST["id"]);
}


?>