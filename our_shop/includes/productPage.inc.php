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
    //check if db exists. Create new db if not exists yet.
    $conn = $this->connectDataBase();
    //if $conn error meaning db not exists, create new one
    if($conn === error){
      $this->createDataBase();
      // do we need to do connect again here?
    }
    $this->displayUI($conn);
    $this->closeDataBase($conn);
  }

  private function displayUI(){
    $this->displayListProduct($conn);
  }

  private function connectDataBase(){

  }

  private function closeDataBase(){

  }

  private function createDataBase(){

  }

  private function displayListProduct($conn){

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