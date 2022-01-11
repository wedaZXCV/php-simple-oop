//MAIN TESTING CODE

// these variable does global effect. It goes into createNewCart function successfully
let button = document.getElementById("cart-name-button");
let delAllButton = document.getElementById("delete-all-cart-button");


function createNewCart(){
  let cartname = document.getElementById("cart-name-input").value;
  let cartnote = document.getElementById("cart-note-input").value;
  if(cartname != ""){
    console.log("Your cartname is now named as "+cartname);
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      if (xhttp.readyState === 4 && xhttp.status === 200) {
        console.log("success");
        document.getElementById("grids").innerHTML = xhttp.responseText;
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

function deleteAllCart(){
  if(confirm("Are you sure want to delete all of the cart?")){
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      if(xhttp.readyState === 4 && xhttp.status === 200){
        console.log("success");
        document.getElementById("txtHint").innerHTML = xhttp.responseText;
        let content = document.getElementById("grids-content");
        content.remove();
      } else{
        console.log(xhttp.status);
      }
    }
    xhttp.open('POST',"functions/deleteAllCarts.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("delete=true");
    console.log("you have deleted all cart");
  }else{
    console.log("you cancel the delete");
  }
}
button.addEventListener("click", createNewCart, false);
delAllButton.addEventListener("click", deleteAllCart, false);
