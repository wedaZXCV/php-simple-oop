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

  // The initiator code for displaying 
  public function initialLoad(){
    $conn = $this->connectDataBase($withdb = FALSE);
    $this->checkDBandTable();
    
    $this->displayUI($conn);
    $this->closeDataBase($conn);
  }
  // the HTML routines comes into main php of product page(product.php)
  // So now here, the <div> parts only
  private function displayUI(){
    //HTML codes before list table
    echo "
    
    
    ";
    //HTML codes to call entries from mySQL
    $this->displayListProduct($conn);
    //HTML codes after list table
    echo "
    
    
    ";
  }

  private function connectDataBase($withdb = TRUE){
    if($withdb == TRUE){
      $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->db);
    } else{
      $conn = new mysqli($this->dbhost, $this->dbuser, $this->dbpass);
    }
    return $conn;
  }

  private function closeDataBase($conn){
    $conn -> close();
  }

  private function checkDBandTable(){
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
          <td>".$row["id"]."</td>
          <td>".$row["name"]."</td>
          <td>".$row["price"]."</td>
          <td>".$row["qtt"]."</td>
        </tr>
        ";
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