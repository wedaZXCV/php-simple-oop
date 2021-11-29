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
if(isset($_POST["all"])){
  //$productIns->deleteSelected($_POST["item"]);
  echo "delete checked, id(s) are: ";
  foreach($_POST["item"] as $value){
    echo($value).", ";
  }
} else if(isset($_POST["one"])){
  //$productIns->deleteOne($_POST["item"]);
  echo "delete one, id no-".$_POST["one"];
} else{
  echo "Error occured while doing the function, check delete button access";
}


// echo"<h1>Successfully reach here! Delete checked.</h1><br>";
// echo(gettype($_POST["item"])."<br>");
// if(!isset($_POST["item"])){
//   echo"No item was selected.";
// } else{
//   $N = count($_POST["item"]);
//   echo "item id(s) were: ";
//   for($i=0; $i<$N; $i++){
//     echo($_POST["item"][$i]."  ");
//   }
// }
?>