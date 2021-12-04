<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/product.css">
  <title>Product list</title>
</head>
<body>
<?php 
  /* product.php
  in here, we are supposed to do product listing, So first thing we need to do
  is to create data base From our web application. Then we can fullfil:
  1. Add product + quantity for stock + pricing
  2. Remove product
  */
  require "includes/productPage.inc.php";

  // 1. Create database and product table if none was exist
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";
  $prdPage = new ProductPage($dbhost, $dbuser, $dbpass, $db);
  $prdPage->initialLoad();

  // 2. Add product features >>> directly traverse into newProduct.php

  // 3. Remove product features





?>
</body>