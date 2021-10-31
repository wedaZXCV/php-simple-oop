<?php 
class CartItem{
  private Product $product;
  private int $quantity;

  public function __construct(\Product $product, $quantity){
    $this->product = $product;
    $this->quantity = $quantity;
  }

  public function increaseQuantity($amount = 1){
    if($this->getQuantity() + $amount > $this->getProduct()->getAvailableQuantity()){
      throw new Exception("Product quantity can not be more than ".$this.getProduct()->getAvailableQuantity());
    }
    $this->quantity += $amount;
  }

  public function decreaseQuantity($amount = 1){
    if($this->getQuantity() - $amount < 1){
      throw new Exception("Product quantity can not be less than 1");
    }
    $this->quantity -= $amount;
  }

  /**
   * Get the value of product
   */ 
  public function getProduct()
  {
    return $this->product;
  }

  /**
   * Set the value of product
   *
   * @return  self
   */ 
  public function setProduct($product)
  {
    $this->product = $product;

    return $this;
  }

  /**
   * Get the value of quantity
   */ 
  public function getQuantity()
  {
    return $this->quantity;
  }

  /**
   * Set the value of quantity
   *
   * @return  self
   */ 
  public function setQuantity($quantity)
  {
    $this->quantity = $quantity;

    return $this;
  }
}


?>