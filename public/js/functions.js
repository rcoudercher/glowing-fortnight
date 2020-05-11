function vote(el, type, rating) {
  
  // input validation
  
  // el = clicked element
  if (el === null) {
    return console.log("Invalid function parameter: 'el' was null.");
  }
  
  // type = "post", "comment"
  if (type != "post" && type != "comment") {
    return console.log("Invalid function parameter: 'type' must be 'post' or 'comment'.");
  }
  
  // rating = "up", "down"
  if (rating != "up" && rating != "down") {
    return console.log("Invalid function parameter: 'rating' must be 'up' or 'down'.");
  }
  
  var wrapper = el.closest(".voteWrapper");
  var hash = wrapper.parentNode.getAttribute("data-hash");
  
  var protocol = window.location.protocol;
  var host = window.location.host;    
  
  if (type == "post") {
    var url = protocol + "//" + host + "/post/" + hash + "/vote";
  } else {
    var url = protocol + "//" + host + "/comment/" + hash + "/vote";
  }
      
  // creates a formData variable to indicate to the controller if user wants to up or down vote the post
  var formData = new FormData();
  if (rating == "up") {
    formData.set("rating", "up");
  } else {
    formData.set("rating", "down");
  }
  
  var csrf = document.getElementsByName("csrf-token").item(0).getAttribute("content");
  var xhr = new XMLHttpRequest();
  xhr.responseType = "json";
  xhr.open("POST", url);    
  xhr.setRequestHeader("x-csrf-token", csrf);
  xhr.onreadystatechange = function () {
    if(xhr.readyState === 4 && xhr.status === 200) {
      // if request was successful, we store the JSON response in a "response" variable
      var response = xhr.response;
      
      if (response === null) {
        return console.log("Request failed: response was null");
      }
      
      if (response["success"] == false) {
        if (response["reason"] == "unauthenticated") {
          return window.location.replace(response["redirect"]);
        } else {
          return console.log(response["reason"]);
        }
      }
      
      console.log(response);
      
      var up = wrapper.firstElementChild;
      var down = wrapper.lastElementChild;
      
      if (response["state"] == "up") {
        up.classList.add("active");
        down.classList.remove("active");
      } else if (response["state"] == "down") {
        up.classList.remove("active");
        down.classList.add("active");
      } else {
        up.classList.remove("active");
        down.classList.remove("active");
      }
      
    } else if(xhr.status >= 500) {
      // internal server error
      console.log("500 (Internal Server Error)");
    } else if(xhr.status >= 402 && xhr.status <= 420) {
      // error
      console.log("error 402 to 420");
    } else if(xhr.status == 400 || xhr.status == 401) {
      // bad request & unauthorized error
      console.log("bad request & unauthorized error");
    }
  };
  xhr.send(formData);
}

function refreshVoteCounter(el, type) {
  // el = clicked element
  
  // type = "post", "comment"
  if (type != "post" && type != "comment") {
    return console.log("Invalid function parameter: 'type' must be 'post' or 'comment'.");
  }
  
  var wrapper = el.closest(".voteWrapper");  
  var hash = wrapper.parentNode.getAttribute("data-hash");
  
  // create post url
  var protocol = window.location.protocol;
  var host = window.location.host;
  
  if (type == "post") {
    var url = protocol + "//" + host + "/post/" + hash + "/vote-count";
  } else {
    var url = protocol + "//" + host + "/comment/" + hash + "/vote-count";
  } 
  
  var csrf = document.getElementsByName("csrf-token").item(0).getAttribute("content");
  var xhr = new XMLHttpRequest();
  xhr.responseType = "json";
  xhr.open("get", url);
  xhr.setRequestHeader("x-csrf-token", csrf);
  
  xhr.onreadystatechange = function () {
    if(xhr.readyState === 4 && xhr.status === 200) {
      var response = xhr.response;
      if (response === null) {
        return console.log("Request failed: response was null");
      }
      console.log(response);
      
      if (type == "post") {
        var counter = wrapper.children.item(1);
      } else {
        var counter = document.getElementById("counter-" + hash);
      }
      
      counter.textContent = response["counter"];
      
    } else if(xhr.status >= 500) {
      // internal server error
      console.log("internal server error");
    } else if(xhr.status >= 402 && xhr.status <= 420) {
      // error
      console.log("error 402 to 420");
    } else if(xhr.status == 400 || xhr.status == 401) {
      // bad request & unauthorized error
      console.log("bad request & unauthorized error");
    }
  };
  xhr.send();
}


