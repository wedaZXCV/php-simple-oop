<?php 
require_once "productPage.inc.php";
class Product extends ProductPage{
  private int $id;
  private string $title;
  private float $price;
  private int $availableQuantity;
  private ProductPage $prdPage;

  // construct method happens while creating new class Object
  // it does defining action for class variables value based on arguments
  //given inside New object parenthesis
  public function __construct(\ProductPage $prdPage){
    $this->prdPage = $prdPage;
  }

  public function addNewProduct($id, $title, $price, $availableQuantity){
    $conn = $this->prdPage->connectDataBase();
    $conn->query("INSERT INTO products VALUES($id, '$title', $price, $availableQuantity);");
    $this->prdPage->closeDataBase($conn);
  }

  public function clearAllProduct(){
    $conn = $this->prdPage->connectDataBase();
    $conn->query("DELETE FROM products");
    $this->prdPage->closeDataBase($conn);
    header("Location: ../product.php", TRUE, 301);
  }

  public function increaseQtty(){

  }

  public function decreaseQtty(){

  }

  public function removeProduct(){

  }



  /**
   * Get the value of id
   */ 
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of title
   */ 
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */ 
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of price
   */ 
  public function getPrice()
  {
    return $this->price;
  }

  /**
   * Set the value of price
   *
   * @return  self
   */ 
  public function setPrice($price)
  {
    $this->price = $price;

    return $this;
  }

  /**
   * Get the value of availableQuantity
   */ 
  public function getAvailableQuantity()
  {
    return $this->availableQuantity;
  }

  /**
   * Set the value of availableQuantity
   *
   * @return  self
   */ 
  public function setAvailableQuantity($availableQuantity)
  {
    $this->availableQuantity = $availableQuantity;

    return $this;
  }
}

?>