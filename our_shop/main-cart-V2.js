//MAIN TESTING CODE

// these variable does global effect. It goes into createNewCart function successfully
let button = document.getElementById("cart-name-button");


console.log("V2 JS loaded ");



function createNewCart(event){
  event.preventDefault();
  let cartnote = document.getElementById("cart-note-input").value;
  let cartname = prompt("Please enter the new cart name, (please camel case):");
  if(cartname == ""){
    alert("Just fill it, or cancel!");
  } else if(!cartname == ""){
    alert("Cart is named as " + cartname);
  }
  if(cartname != ""){
    console.log("Cart is named as " + cartname);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      if (xhttp.readyState === 4 && xhttp.status === 200) {
        console.log("success");
        document.getElementById("txtHint").innerHTML = xhttp.responseText;
      } else{
        console.log(xhttp.status);
      }
    }
    xhttp.open('POST',"functions/createCart.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("cartname="+cartname+"&cartnote="+cartnote);
  } else{
    console.log("You need to add a name or something.");
  }
}
button.addEventListener("click", createNewCart, false);