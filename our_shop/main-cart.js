//MAIN TESTING CODE

// these variable does global effect. It goes into createNewCart function successfully
let button = document.getElementById("cart-name-button");



function createNewCart(){
  let cartname = document.getElementById("cart-name-input").value;
  if(cartname != ""){
    console.log("Your cartname is now named as "+cartname);
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
    xhttp.send("cartname="+cartname);
  } else{
    console.log("You need to add a name or something.");
  }
}
button.addEventListener("click", createNewCart, false);