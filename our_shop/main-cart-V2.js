//MAIN TESTING CODE

// these variable does global effect. It goes into createNewCart function successfully
let button = document.getElementById("cart-name-button");


console.log("JS loaded ");



function createNewCart(){
  let cartname = document.getElementById("cart-name-input").value;
  if(cartname != ""){
    console.log(cartname);
  }
}
button.addEventListener("click", createNewCart, false);