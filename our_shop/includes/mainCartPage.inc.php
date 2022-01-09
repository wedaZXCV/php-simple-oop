<?php 
class MainCartPage{
  private string $dbhost;
  private string $dbuser;
  private string $dbpass;
  private string $db;

  public function __construct($dbhost, $dbuser, $dbpass, $db){
    $this->dbhost = $dbhost;
    $this->dbuser = $dbuser;
    $this->dbpass = $dbpass;
    $this->db = $db;
  }

  // The initiator code for displaying on main cart Page
  public function initialLoad(){
  $conn = $this->connectDataBase($withdb = FALSE);
  $this->checkDBandTable($conn);
  //$this->displayUIV2($conn);
  $this->displayUI($conn);
  $this->closeDataBase($conn);
  }

  protected function connectDataBase($withdb = TRUE){
    if($withdb == TRUE){
      $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->db);
    } else{
      $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass);
    }
    return $conn;
  }

  private function checkDBandTable($conn){
    //check if db exists. Create new db if not exists yet.
    $result = $conn->query("USE ".$this->db);
    if(!$result){
      if($conn->errno === 1049){
        $conn->query("CREATE DATABASE ".$this->db);
        $conn->query("USE ".$this->db);
      }
    }
    //check if table exists. Create new table if not exists yet.
    $result = $conn->query("SELECT * FROM cartlist");
    if(!$result){
      //create table
      $conn->query("CREATE TABLE cartlist(id INT(255) UNSIGNED, name VARCHAR(50), note TEXT(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci);");
    }
  }
  
  protected function closeDataBase($conn){
    $conn -> close();
  }

  private function displayUIV2($conn){
    // firstly first, do retreive data from SQL server. The data to display by the UI
    //INITIAL
    [$idArr, $nameArr, $noteArr] = $this->fetchData($conn);
    //HTML codes before cart grid
    echo "
    <div class=\"header\">
      CHAOS MART
    </div>
    <div class=\"title\">
      <h1>MAIN CART PAGE</h1>
    </div>
    <div class=\"subtitle\">
      <h3>Check cart to start shopping. If there is none, you can create one or
      multiple new carts. You can add multiple cart for various kind of purposes.
      Remove cart(s) using delete menu from \"Remove existing cart\" button.
      </h3>
    </div>";
    //Creating new cart functionality
    echo "
    <div class=\"form-rows\">
      <p>What is your need? What will be this cart used for?
      </p>
    </div>
    <div class=\"form-rows\">
      <textarea id=\"cart-note-input\" rows=\"5\" cols=\"75\" placeholder=\"Add some note...\"></textarea>
    </div>
    <input id=\"cart-name-button\" type=\"button\" value=\"create cart\">
    ";
    echo "
      <div id=\"txtHint\"></div>
    ";

    //HTML codes after cart grid
    echo "
    <br>
    <br>
    <br>
    <div class=\"footer\">
      copyright &copy HinterRollover 2021, allright reserved.
    </div>
    ";
  }

  private function displayUI($conn){
    // firstly first, do retreive data from SQL server. The data to display by the UI
    //INITIAL
    [$idArr, $nameArr, $noteArr] = $this->fetchData($conn);
    
    //HTML codes before cart grid
    echo "
    <div class=\"header\">
      CHAOS MART
    </div>
    <div class=\"title\">
      <h1>MAIN CART PAGE</h1>
    </div>
    <div class=\"subtitle\">
      <h3>Check cart to start shopping. If there is none, you can create one or
      multiple new carts. You can add multiple cart for various kind of purposes.
      Remove cart(s) using delete menu from \"Remove existing cart\" button.
      </h3>
    </div>";
    //Creating new cart functionality
    echo "
    <div class=\"form\">
      <p class=\"form-rows\">
        <div class=\"label-input\">
          <label for=\"cart-name-input\">Cart Name: </label>
        </div>
        <input id=\"cart-name-input\" type=\"text\" class=\"inputs\" placeholder=\"Add the cart name...\">
      </p>
      <p class=\"form-rows\">
        <div class=\"label-input\">
          <label for=\"cart-note-input\">Cart Note: </label>
        </div>
        <textarea id=\"cart-note-input\" placeholder=\"Add some note...\" rows=\"4\" cols=\"50\" class=\"inputs\"></textarea>
      </p>
    </div>
    <input id=\"cart-name-button\" type=\"button\" value=\"create cart\" class=\"inputs\">
    ";
    echo "
      <div id=\"txtHint\"></div>
    ";
    //HTML codes as an output for cart grid display
    echo "
      <div id=\"grids\">
    ";
    $this->displayCarts($idArr, $nameArr, $noteArr);
    echo "
      </div>
    ";

    //HTML codes after cart grid
    echo "
    <br>
    <br>
    <br>
    <div class=\"footer\">
      copyright &copy HinterRollover 2021, allright reserved.
    </div>
    ";
  }

  protected function fetchData($conn){
    $result = $conn->query("SELECT * FROM cartlist ORDER BY id");
    //assign every data into new array
    if($result->num_rows > 0){
      $idArr = array();
      $nameArr = array();
      $noteArr = array();
      while($row = $result->fetch_assoc()){
        array_push($idArr, $row["id"]);
        array_push($nameArr, $row["name"]);
        array_push($noteArr, $row["note"]);
      }
      //serialize to make compact version, for return value
      $idArr = serialize($idArr);
      $nameArr = serialize($nameArr);
      $noteArr = serialize($noteArr);
      return [$idArr, $nameArr, $noteArr];
    } else{
      echo "actually we get an empty set. Sorry...";
    }
  }

  protected function displayCarts($idArr, $nameArr, $noteArr){
    $newidArr = unserialize($idArr);
    $newnameArr = unserialize($nameArr);
    $newnoteArr = unserialize($noteArr);

    //The grid should be having 6 items per row.
    // so we need to calculate how many rows initially.
    $gridRows = ceil(count($newidArr) / 6);
    $counter = 0;

    echo"<div id=\"grids\">";
    for($itt=0; $itt<$gridRows; $itt++){
      echo"<div class=\"grid-row\">";
      for($j=0; $j<6; $j++){
        if(isset($newidArr[$counter])){
          echo"
          <div class=\"grid-col\" id=\"id-".$newidArr[$counter]."\">
            <div class=\"grid-text-container\">
              <p class=\"grid-text\">
                ".$newnameArr[$counter]."
              </p>
            </div>
          </div>
          ";
          $counter += 1;
        } else{
          break;
        }
      }
      echo"</div>";
    }
    echo"</div>";


  }


}


  












?>