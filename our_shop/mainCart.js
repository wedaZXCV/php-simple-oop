function newCart(){
  let cartname = prompt("Please enter the new cart name, (please camel case):");
  if(cartname == ""){
    alert("Just fill it, or cancel!");
  } else if(!cartname == ""){
    alert("Cart is named as " + cartname);
    createCart("functions/createCart.php", cartname);
  }
}

function createCart(targetURL, name){
  //AJAX USING XMLHTTPREQUEST
  console.log(name);
  var xhttp = new XMLHttpRequest();
  var data = JSON.stringify({"name": name});
  xhttp.open('POST', targetURL, true);
  xhttp.setRequestHeader("Content-Type", "application/json;  charset=UTF-8");
  xhttp.onreadystatechange = function () {
    if (xhttp.readyState === 4 && xhttp.status === 200) {
      console.log("success");
    }
  };
  
  xhttp.send(data);
}