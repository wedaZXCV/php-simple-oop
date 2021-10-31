<?php 
class Product{
  private int $id;
  private string $title;
  private float $price;
  private int $availableQuantity;

  public function __construct($id, $title, $price, $availableQuantity){
    $this->id = $id;
    $this->title = $title;
    $this->price = $price;
    $this->availableQuantity = $availableQuantity;
  }

  /**
   * Add Product $product into cart. If product already exists inside cart
   * it must update quantity.
   * This must create CartItem and return CartItem from method
   * Bonus: $quantity must not become more than whatever
   * is $availableQuantity of the Product.
   * 
   * @param Cart $cart
   * @param int $quantity
   * @return void
   * @return CartItem
   */
  public function addToCart(Cart $cart, int $quantity){
    return $cart->addProduct($this, $quantity);
  }
  /**
   * Remove product from cart
   * 
   * @param Cart $cart
   */
  public function removeFromCart(Cart $cart){
    $cart->removeProduct($this);
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