<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/product.css">
  <title>Main cart</title>
</head>
<body>
  <p id="mey"></p>
<?php 
  /* mainCart.php

  mainCart.php is dedicated for handling multiple shopping cart for user.
  User can decide to create more shopping cart, so he can organize more about
  his shopping priority.

  1. Creating cart
  2. Destroy cart
  3. Display cart
  4. Destroy all cart
  5. Return to main menu page

  note: we are using the same database with the product list.
  just different table.
  */
  require "includes/mainCartPage.inc.php";

  // 1. Create database and cart table if none was exist
  $dbhost = "localhost:3306";
  $dbuser = "root";
  $dbpass = "Hinterrollover7<3";
  $db = "shopping";
  $prdPage = new MainCartPage($dbhost, $dbuser, $dbpass, $db);
  $prdPage->initialLoad();

  // all of the main features is within the initialLoad function
  // except the front-end actions. It's on script bellow:
?>
</body>
<script src="mainCart.js"></script>