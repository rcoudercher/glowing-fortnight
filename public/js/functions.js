function postVote(el, rating) {
  
  // input validation
  
  // el = clicked element
  if (el === null) {
    return console.log("Invalid function parameter: 'el' was null.");
  }
  
  // rating = "up", "down"
  if (rating != "up" && rating != "down") {
    return console.log("Invalid function parameter: 'rating' must be 'up' or 'down'.");
  }
  
  var wrapper = el.closest(".voteWrapper");
  var hash = wrapper.parentNode.getAttribute("data-post");
  
  var protocol = window.location.protocol;
  var host = window.location.host;    
  var url = protocol + "//" + host + "/" + hash + "/" + "vote-post";
      
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
  xhr.open("post", url);    
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
      
      var up = wrapper.children.item(0);
      var down = wrapper.children.item(2);
      
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
      console.log("internal server error");
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

function refreshVoteCounter(el) {
  // el = clicked element
  var wrapper = el.closest(".voteWrapper");  
  var hash = wrapper.parentNode.getAttribute("data-post");
  
  // create post url
  var protocol = window.location.protocol;
  var host = window.location.host;    
  var url = protocol + "//" + host + "/" + hash + "/" + "vote-count";  
  
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
      var counter = wrapper.children.item(1);
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
