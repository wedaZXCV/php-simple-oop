<?php 
class ProductPage{
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

  // The initiator code for displaying on main Product Page
  public function initialLoad(){
    $conn = $this->connectDataBase($withdb = FALSE);
    $this->checkDBandTable($conn);
    
    $this->displayUI($conn);
    $this->closeDataBase($conn);
    // if($conn->ping() == TRUE){
      
    // }
  }
  // The initiator code for displaying on Add New Product Page
  public function loadAddNewPrdPage(){
    $conn = $this->connectDataBase();
    $this->displayAddNewPrd($conn);
    $this->closeDataBase($conn);
  }

  // the HTML routines comes into main php of product page(product.php)
  // So now here, the <div> parts only
  // the displayUI bellow is for main Product Page
  private function displayUI($conn, $displaying = 15, $minimalPages = 11){
    // firstly first, do retreive data from SQL server. The data to display by the UI
    if(!isset($_POST["pagination-clicked"])){
      if(!isset($_GET["sort"])){
        [$idArr, $nameArr, $priceArr, $qttArr, $totalItem] = $this->fetchData($conn);
      } else{
        [$idArr, $nameArr, $priceArr, $qttArr, $totalItem] = $this->fetchData($conn, $_GET["sort"]);
      }
    } else{
      // do not do the fetch anymore if pagination button was clicked
    }
    
    
    //HTML codes before list table
    echo "
    <div class=\"header\">
      CHAOS MART
    </div>
    <div class=\"title\">
      <h1>PRODUCT LIST</h1>
    </div>
    <div class=\"subtitle\">
      <h3>Product list consist of various item that are being sold and available for customers.
        The available quantity and the pricing of each item is well informed through the list.
        You as the administrator should be able to keep on track with the update of stock condition.
        You can add new product or remove the existing product on the list.
        Use the bellow checkbox to choose every item to be cleared, or hover mouse over an item to change its
        quantity and/or price. Delete individual item one by one is also available.
      </h3>
    </div>";
    //HTML codes to add new entries to mySQL
    echo "
    <form class=\"product-main-page-btn\" action=\"newProduct.php\" method=\"POST\">
      <button type=\"submit\" class=\"buttons\">ADD NEW PRODUCT</button>
    </form>
    ";

    //HTML codes for displaying some functionalities
    $this->clearAllProduct($conn);
    //$this->searchProduct($conn);
    $this->paginationDisplay($conn, $totalItem, $displaying, $minimalPages, $idArr, $nameArr, $priceArr, $qttArr);

    echo "<div class=\"item-table-container\">
    <form action=\"functions/delete.php\" method=\"POST\">
      <table class=\"item-table\">
        <tr>
          <th class=\"cb-th\"></th>
          <th><a href=\"product.php?sort=id\">Id</a></th>
          <th><a href=\"product.php?sort=name\">Name of product</a></th>
          <th><a href=\"product.php?sort=price\">Price</a></th>
          <th><a href=\"product.php?sort=qtt\">Quantity in stock</a></th>
          <th class=\"button-th\"></th>
        </tr>
    ";
    //HTML codes to call entries from mySQL
    if(!isset($_POST["pagination-clicked"])){
      $this->displayListProduct($conn, $displaying, $idArr, $nameArr, $priceArr, $qttArr);
    } else{
      $this->displayListProduct($conn, $displaying, $idArr, $nameArr, $priceArr, $qttArr, $_POST["page-number"]);
    }
    
    
    //HTML codes after list table
    echo "
    </table>
      <button type=\"submit\" name=\"all\">Delete checked</button>
    </form>
    </div>
    <div class=\"footer\">
      copyright &copy HinterRollover 2021, allright reserved.
    </div>
    ";
  }

  private function displayAddNewPrd($conn){
    //HTML codes before main form
    echo "
    <div class=\"header\">
      CHAOS MART
    </div>
    <div class=\"title\">
      <h1>ADD NEW PRODUCT</h1>
    </div>
    <div class=\"subtitle\">
      <h3>Add new product by giving them product name, price, and initial quantity.
      </h3>
    </div>
    ";
    //HTML codes for the main form
    echo"
    <form class=\"add-new-product\" action=\"newProduct.php\" method=\"POST\">
      <div class=\"form-rows\">
        <div class=\"labels\">
          <label for=\"prdname\" id=\"prdname-label\">Name</label>
        </div>
        <div class=\"fields\">
          <input type=\"text\" id=\"prdname\" name=\"name\" class=\"input-fields\" placeholder=\"Enter the name for the product\" required>
        </div>
      </div>

      <div class=\"form-rows\">
        <div class=\"labels\">
          <label for=\"prdprice\" id=\"prdprice-label\">Price</label>
        </div>
        <div class=\"fields\">
          <input type=\"text\" id=\"prdprice\" name=\"price\" class=\"input-fields\" placeholder=\"Enter the price for the product\" required>
        </div>
      </div>

      <div class=\"form-rows\">
        <div class=\"labels\">
          <label for=\"prdqtt\" id=\"prdqtt-label\">Quantity</label>
        </div>
        <div class=\"fields\">
          <input type=\"text\" id=\"prdqtt\" name=\"qtt\" class=\"input-fields\" placeholder=\"Enter the initial quantity for the product\" required>
        </div>
      </div>

      <button type=\"submit\" class=\"buttons\">ADD PRODUCT</button>
      
    </form>
    ";
    //HTML codes after the main form
    echo "
    <div class=\"footer\">
      copyright &copy 2021, allright reserved.
    </div>
    ";
  }

  protected function connectDataBase($withdb = TRUE){
    if($withdb == TRUE){
      $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->db);
    } else{
      $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass);
    }
    return $conn;
  }

  protected function closeDataBase($conn){
    $conn -> close();
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
    $result = $conn->query("SELECT * FROM products");
    if(!$result){
      //create table
      $conn->query("CREATE TABLE products(id INT(255) UNSIGNED, name VARCHAR(50), price DECIMAL(10,2), qtt INT(255));");
      $result = $conn->query("SELECT * FROM products");
    }
  }

  // Here is also doing sorting mode for the display
  private function fetchData($conn, $sort="name"){
    // the product items is sorted by name by default
    if($sort == "id"){
      $result = $conn->query("SELECT * FROM products ORDER BY id");
    }else if($sort == "name"){
      $result = $conn->query("SELECT * FROM products ORDER BY name");
    } else if($sort == "price"){
      $result = $conn->query("SELECT * FROM products ORDER BY price");
    } else if($sort == "qtt"){
      $result = $conn->query("SELECT * FROM products ORDER BY qtt");
      //default
    } else{
      echo "something wrong with the displaying functionality";
    }

    //assign every data into new array
    if($result->num_rows > 0){
      $idArr = array();
      $nameArr = array();
      $priceArr = array();
      $qttArr = array();
      while($row = $result->fetch_assoc()){
        array_push($idArr, $row["id"]);
        array_push($nameArr, $row["name"]);
        array_push($priceArr, $row["price"]);
        array_push($qttArr, $row["qtt"]);
      }
    }
    //serialize to make compact version, for return value
    $idArr = serialize($idArr);
    $nameArr = serialize($nameArr);
    $priceArr = serialize($priceArr);
    $qttArr = serialize($qttArr);

    $totalItem = $result->num_rows;
    //returns all of the entry arrays and the $totalItem for pagination
    return [$idArr, $nameArr, $priceArr, $qttArr, $totalItem];
  }

  
  private function displayListProduct($conn, $displaying, $idArr, $nameArr, $priceArr, $qttArr, $pageNumber=1){
    //unserialize first
    //$nameArr = unserialize($_POST['array_data']);  << for example
    $newidArr = unserialize($idArr);
    $newnameArr = unserialize($nameArr);
    $newpriceArr = unserialize($priceArr);
    $newqttArr = unserialize($qttArr);

    // define start index location of current page
    if($pageNumber == 1){
      $itemStartIndex = 0;
    } else{
      $itemStartIndex = $pageNumber * $displaying - $displaying;
    }

    // later, print only $displaying items
    $displayID = $this->prepareListEntryDisplay($newidArr, $itemStartIndex, $displaying);
    $displayName = $this->prepareListEntryDisplay($newnameArr, $itemStartIndex, $displaying);
    $displayPrice = $this->prepareListEntryDisplay($newpriceArr, $itemStartIndex, $displaying);
    $displayQtt = $this->prepareListEntryDisplay($newqttArr, $itemStartIndex, $displaying);
    
    foreach($displayID as $key=>$value){
      echo "
      <tr>
        <td><input type=\"checkbox\" id=\"itemid".$displayID[$key]."\" name=\"item[]\" value=\"".$displayID[$key]."\"></td>
        
        <td>".$displayID[$key]."</td>
        <td>".$displayName[$key]."</td>

        <td><a href=\"functions/modify.php?price=".$displayPrice[$key]."&name=".$displayName[$key]."&qtt=".$displayQtt[$key]."&id=".$displayID[$key]."\">".$displayPrice[$key]."</a></td>

        <td class=\"quantity-td\"><a href=\"functions/modify.php?qtt=".$displayQtt[$key]."&name=".$displayName[$key]."&price=".$displayPrice[$key]."&id=".$displayID[$key]."\">".$displayQtt[$key]."</a></td>

        <td class=\"one-delete-td\">
          <button type=\"submit\" class=\"one-delete-btn\" name=\"one\" value=\"".$displayID[$key]."\">DELETE</button>
        </td>
      
      </tr>
    ";
    }

  }

  private function prepareListEntryDisplay($arrayEntry, $itemStartIndex, $displaying){
    $displayArr = array();
    for($i = $itemStartIndex; $i < ($itemStartIndex + $displaying); $i++){        
      // if the $arrayEntry[$i] is null, so break loop
      if(!isset($arrayEntry[$i])){
        break;
      }
      array_push($displayArr, $arrayEntry[$i]);
    }
    return $displayArr;
  }

  private function clearAllProduct($conn){
    echo " 
    <form action=\"functions/deleteAll.php\" type=\"POST\">
      <button type=\"submit\">Clear All</button>
    </form>
    ";
  }

  private function paginationDisplay($conn, $totalItem, $displaying, $minimalPages, $idArr, $nameArr, $priceArr, $qttArr){
    // firstly first get the $pages from $totalItem and $displaying
    $pages = ceil($totalItem / $displaying);

    // Add hidden form to confirm when any pagination button is clicked
    echo "
    <form action=\"product.php\" method=\"post\">
      <!-- pagination-clicked to check if it's no need to query anymore,
        the next display will be not initial display anymore-->
      <input type=\"hidden\" name=\"pagination-clicked\" value=\"True\">

      <!-- data arrays which are the data fetched from SQL, already sorted.
        Is passed to the next page (every page of pagination)-->
      <input type=\"hidden\" name=\"id-array\" value=\"".$idArr."\">
      <input type=\"hidden\" name=\"name-array\" value=\"".$nameArr."\">
      <input type=\"hidden\" name=\"price-array\" value=\"".$priceArr."\">
      <input type=\"hidden\" name=\"qtt-array\" value=\"".$qttArr."\">
    </form>
    ";

    // $pages reachs minimal amount for displaying in accordion
    // basically, accordion format simplifies the display from being too much
    if($pages >= $minimalPages){
      //#1 initial displaying  << always page number 1
      if(!isset($_POST["page-number"])){
        for($i = 1; $i <= 3; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        }
        echo "<div class=\"t-dot-pages\"> ... </div>";
        for($i = $pages-2; $i <= $pages; $i++){
          echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
        }

        // highlight page number 1
        echo "<style type=\"text/css\">
        #pb-1{
          border-style: solid;
          border-color: red;
        }
        </style>";

      //#2 checking current page location  << for clicked page number
      } else{
        // check if the selected page number is at near the top start or top end
        if(($_POST["page-number"]>=1 && $_POST["page-number"]<=2) || ($_POST["page-number"]>=$pages-1 && $_POST["page-number"]<=$pages)){
          for($i = 1; $i <= 3; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          }
          echo "<div class=\"t-dot-pages\"> ... </div>";
          for($i = $pages-2; $i <= $pages; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          } 

          // check if the selected page number is at pre-center or center point
          // at pre-center point, like 3 and $pages-2
        } else if($_POST["page-number"] == 3 || $_POST["page-number"] == $pages-2){
          for($i = 1; $i <= 3; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          }
          echo "<div class=\"t-dot-pages\"> ... </div>";
          // the 3 or the $pages-2?
          if($_POST["page-number"] == 3){
            for($i = 3+1; $i <= 3+1+4; $i++){
              echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
            }
          } else if($_POST["page-number"] == $pages-2){
            for($i = $pages-7; $i <= $pages-7+4; $i++){
              echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
            } 
          }
          echo "<div class=\"t-dot-pages\"> ... </div>";
          for($i = $pages-2; $i <= $pages; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          }
          
          // at center point
        } else {
          for($i = 1; $i <= 3; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          } 
          echo "<div class=\"t-dot-pages\"> ... </div>";
          
          // here the current page number can be set as the mid point
          if($_POST["page-number"]-2 > 3 && $_POST["page-number"]+2 < $pages-2){
            for($i = $_POST["page-number"]-2; $i < $_POST["page-number"]-2+5; $i++){
              echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
            }
          } 
          // here the current page number can not be set as the mid point
          else {
            // Where is the loc? near start or end?
            if($_POST["page-number"] <= 3+2){
              $itt = 3+1;
              for($i = $itt; $i < $itt+5; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              }
            } else if($_POST["page-number"] >= ($pages-2)-2){
              $itt = $pages-7;
              for($i = $itt; $i < $itt+5; $i++){
                echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
              }
            }
          }
          echo "<div class=\"t-dot-pages\"> ... </div>";
          for($i = $pages-2; $i <= $pages; $i++){
            echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
          }
        }
      }

    // on the other hand, $pages doesn't reach minimal amount, meaning we don't need accordion
    } else{
      // No accordion, meaning pagination has same displaying
      for($i = 1; $i <= $pages; $i++){
        echo "<button type=\"submit\" name=\"page-number\" value=\"".$i."\" class=\"pagination-button\" id=\"pb-".$i."\">".$i."</button>";
      }
      //#1 initial displaying  << always page number 1
      if(!isset($_POST["page-number"])){
        // highlight page number 1
        echo "<style type=\"text/css\">
        #pb-1{
          border-style: solid;
          border-color: red;
        }
        </style>";

      //#2 checking current page location  << for clicked page number
      } else{
        // highlight the current page-number
        echo "<style type=\"text/css\">
        #pb-".$_POST["page-number"]."{
          border-style: solid;
          border-color: red;
        }
        </style>";
      }
    }
  }

  /**
   * Get the value of dbhost
   */ 
  public function getDbhost()
  {
    return $this->dbhost;
  }

  /**
   * Set the value of dbhost
   *
   * @return  self
   */ 
  public function setDbhost($dbhost)
  {
    $this->dbhost = $dbhost;

    return $this;
  }

  /**
   * Get the value of dbuser
   */ 
  public function getDbuser()
  {
    return $this->dbuser;
  }

  /**
   * Set the value of dbuser
   *
   * @return  self
   */ 
  public function setDbuser($dbuser)
  {
    $this->dbuser = $dbuser;

    return $this;
  }

  /**
   * Get the value of dbpass
   */ 
  public function getDbpass()
  {
    return $this->dbpass;
  }

  /**
   * Set the value of dbpass
   *
   * @return  self
   */ 
  public function setDbpass($dbpass)
  {
    $this->dbpass = $dbpass;

    return $this;
  }

  /**
   * Get the value of db
   */ 
  public function getDb()
  {
    return $this->db;
  }

  /**
   * Set the value of db
   *
   * @return  self
   */ 
  public function setDb($db)
  {
    $this->db = $db;

    return $this;
  }
}



?>