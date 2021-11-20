<?php
  echo"I Am Here\n";
  echo(getcwd());
  require_once "productPage.inc.php";
  require_once "product.inc.php";
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";
  $prdPage = new ProductPage($dbhost, $dbuser, $dbpass, $db);
  $productIns = new Product($prdPage);
  $productIns->clearAllProduct();









?>