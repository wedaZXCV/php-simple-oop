<?php
require "../includes/productPage.inc.php";
require "../includes/product.inc.php";
$dbhost = "localhost:3306";
$dbuser = "root";
$dbpass = "Hinterrollover7<3";
$db = "shopping";
// clearAllProduct
$prdPage = new ProductPage($dbhost, $dbuser, $dbpass, $db);
$productIns = new Product($prdPage);
$productIns->clearAllProduct();









?>