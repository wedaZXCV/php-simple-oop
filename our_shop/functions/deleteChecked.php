<?php 
echo"<h1>Successfully reach here! Delete checked.</h1><br>";

if(!isset($_POST["item"])){
  echo"No item was selected.";
} else{
  $N = count($_POST["item"]);
  echo "item id(s) were: ";
  for($i=0; $i<$N; $i++){
    echo($_POST["item"][$i]."  ");
  }
}


?>