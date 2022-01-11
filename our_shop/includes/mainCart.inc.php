<?php 
require_once "mainCartPage.inc.php";
class MainCart extends MainCartPage{
  private MainCartPage $mainCart;

  public function __construct(\MainCartPage $mainCart){
    $this->mainCart = $mainCart;
  }

  public function connectdb(){
    $conn = $this->mainCart->connectDataBase();
    return $conn;
  }

  public function closedb($conn){
    $this->mainCart->closeDataBase($conn);
  }

  public function addNewCart($conn, $cartname, $cartnote=""){
    $id = $this->autoGenerateID($conn);
    $conn->query("INSERT INTO cartlist VALUES($id, '$cartname', '$cartnote');");
  }

  public function showCarts($conn){
    [$idArr, $nameArr, $noteArr] = $this->mainCart->fetchData($conn);
    //check if the cartlist is populated or empty
    if(isset($idArr)){
      $this->mainCart->displayCarts($idArr, $nameArr, $noteArr);
    }else{
      echo"There is no currently cart available.";
    }
  }

  public function deleteAllCarts($conn){
    $conn->query("DELETE FROM cartlist;");
  }

  private function autoGenerateID($conn){
    $result = $conn->query("SELECT id FROM cartlist ORDER BY id;");
    $arrayNew = array();
    if ($result->num_rows > 0){
      $itt = 0;
      $idt = 0;
      while($row = $result->fetch_assoc()) {
        array_push($arrayNew, $row["id"]);
        if($itt == 0){
          if($row["id"] != 0){
            $idt = 0;
            break;
          } else {
            $idt = $row["id"]+1;
            // no break;
          }
        } else {
          // jumping case
          if(($row["id"] - $temp) > 1){
            $idt = $temp + 1;
            break;
            // normal case
          } else{
            $idt = $row["id"] + 1;
          }
        }
        $itt += 1;
        $temp = $row["id"];
      }
    } else{
      $idt = 0;
    }
    return $idt;
  }

}






?>