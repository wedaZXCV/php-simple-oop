<?php
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
} else if(isset($_POST["price"]) || isset($_POST["qtt"])){
  //do push data to database
}


?>