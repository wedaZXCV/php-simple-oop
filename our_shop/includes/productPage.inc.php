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
  private function displayUI($conn){
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
    //HTML codes to remove all entries from mySQL
    $this->clearAllProduct($conn);

    echo "<div class=\"item-table-container\">
    <form action=\"functions/delete.php\" method=\"POST\">
      <table class=\"item-table\">
        <tr>
          <th class=\"cb-th\"></th>
          <th>Id</th>
          <th>Name of product</th>
          <th colspan=\"2\">Price</th>
          <th colspan=\"2\">Quantity in stock</th>
          <th class=\"button-th\"></th>
        </tr>
    ";
    //HTML codes to call entries from mySQL
    $this->displayListProduct($conn);
    //HTML codes after list table
    echo "
    </table>
      <button type=\"submit\" name=\"all\">Delete checked</button>
    </form>
    </div>
    <div class=\"footer\">
      copyright &copy 2021, allright reserved.
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
          <label for=\"prdid\" id=\"prdid-label\">ID</label>
        </div>
        <div class=\"fields\">
          <input type=\"text\" id=\"prdid\" name=\"id\" class=\"input-fields\" placeholder=\"Enter the id for the product\" required>
        </div>
      </div>

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

  private function displayListProduct($conn){
    $result = $conn->query("SELECT * FROM products");
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        echo "
          <tr>
          
            <td><input type=\"checkbox\" id=\"itemid".$row["id"]."\" name=\"item[]\" value=\"".$row["id"]."\"></td>
            
            <td>".$row["id"]."</td>
            <td>".$row["name"]."</td>

            <td>".$row["price"]."</td>
            <td class=\"modifier-price\">
              <form action=\"functions/modify.php\" method=\"POST\">
                <input type=\"number\" name=\"priceMod\" min=0 class=\"numModifier priceMod\">
                <button type=\"submit\" class=\"confirmModifier\">&#10004;</button>
              </form>
            </td>

            <td class=\"quantity-td\">".$row["qtt"]."</td>
            <td class=\"modifier-qtt\">
              <form action=\"functions/modify.php\" method=\"POST\">
                <input type=\"number\" name=\"qttMod\" min=0 class=\"numModifier qttMod\">
                <button type=\"submit\" class=\"confirmModifier\">&#10004;</button>
              </form>
            </td>

            <td class=\"one-delete-td\">
              <button type=\"submit\" class=\"one-delete-btn\" name=\"one\" value=\"".$row["id"]."\">DELETE</button>
            </td>
          
          </tr>
        ";
      }
    }
  }

  private function clearAllProduct($conn){
    echo " 
    <form action=\"functions/deleteAll.php\" type=\"POST\">
      <button type=\"submit\">Clear All</button>
    </form>
    ";
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