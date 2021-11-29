<?php
  echo"I Am Here\n";
  echo(getcwd());
  require_once "../includes/productPage.inc.php";
  require_once "../includes/product.inc.php";
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";
  $prdPage = new ProductPage($dbhost, $dbuser, $dbpass, $db);
  $productIns = new Product($prdPage);
  $productIns->clearAllProduct();
?>