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

function createNotification(type, message) {
  
  // function inputs validation
  if (type != "success" && type != "warning" && type != "danger") {
    return console.log("createNotification() error: 'type' parameter must be 'success', 'warning' or 'danger'");
  }
  
  if (message === null) {
    return console.log("createNotification() error: null 'message' parameter");
  }
  
  // creates the notification
  var el1 = document.createElement("div");
  el1.classList.add("notification", "py-3", "pl-6", "pr-3", "rounded-lg", "shadow-lg", "mb-4");
  
  var el2 = document.createElement("div");
  el2.classList.add("flex", "items-center", "justify-between", "flex-wrap");
  
  var el3 = document.createElement("div");
  el3.classList.add("w-full", "flex-1", "flex", "items-center", "sm:w-0");
  
  var el4 = document.createElement("p");
  el4.textContent = message;
  
  var el5 = document.createElement("div");
  el5.classList.add("flex-shrink-0");
  
  var el6 = document.createElement("div");
  el6.classList.add("rounded-md", "shadow-sm", "closeNotifBtn", "cursor-pointer");
  
  var el7 = document.createElement("span");
  el7.classList.add("flex", "items-center", "justify-center", "px-4", "py-2", "border", "border-transparent", "text-sm", "leading-5", "font-medium", "rounded", "text-gray-900", "bg-white", "hover:text-gray-600", "focus:outline-none", "focus:shadow-outline", "transition", "ease-in-out", "duration-150");
  el7.textContent = "X";
  
  switch (type) {
    case "success":
      el1.classList.add("bg-green-300");
      el4.classList.add("text-green-900");
      break;
      
    case "warning":
      el1.classList.add("bg-yellow-300");
      el4.classList.add("text-yellow-900");
      break;
      
    case "danger":
      el1.classList.add("bg-red-300");
      el4.classList.add("text-red-900");
      break;
  }
  
  el1.appendChild(el2);
  el2.appendChild(el3);
  el2.appendChild(el5);
  el3.appendChild(el4);
  el5.appendChild(el6);
  el6.appendChild(el7);
  
  console.log(el1);
  
  return el1;
  
}

function addRemoveElementsClickListener(el, wrapper) {
  
  // "el" is the class of the element to add the listener on
  // "wrapper" is the class of the wrapper element
  
  var elements = document.getElementsByClassName(el);
  
  // validation of "el" parameter
  if (elements.length == 0) {
    return console.log("addRemoveElementsClickListener() error: no elements found with class '" + el + "'.");
  }
  
  // validation of "wrapper" parameter
  if (document.getElementsByClassName(wrapper).length == 0) {
    return console.log("addRemoveElementsClickListener() error: no elements found with class '" + wrapper + "'.");
  }
  
  for (var i = 0, len = elements.length; i < len; i++) {
    elements.item(i).addEventListener("click", function(e) {
      let target = e.target || e.srcElement;
      target.closest("." + wrapper).remove();
    });
  }
  
  return console.log("Click listeners successfully added on elements with class '" + el + "'" );
}

function setElementTimeout(el, time) {
  
  // "el" is the class of target elements
  // "time" is the duration of the timeout in milliseconds
  
  if (!Number.isInteger(time)) {
    return console.log("setElementTimeout() error: 'time' parameter must be an integer");
  }
  
  var elements = document.getElementsByClassName(el);
    
  if (elements.length == 0) {
    return console.log("setElementTimeout() error: no elements found with class '" + el + "'.");
  }
  
  setTimeout(function() {
    for (var i = 0, len = elements.length; i < len; i++) {
      elements.item(i).remove();
    }
  }, time);
  
  return console.log("Timeout successfully added on elements with class '" + el + "'" );
}

function toggleShareOptionsDropdown() {
  
  var elements = document.getElementsByClassName("shareBtn");
  
  if (elements.length == 0) {
    return console.log("toggleShareOptionsDropdown() error: no elements found with class 'shareBtn'");
  }
  
  for (var i = 0; i < elements.length; i++) {
    
    elements.item(i).addEventListener("click", function(e) {
      let target = e.target || e.srcElement;
      target.nextElementSibling.classList.toggle("hidden");
      e.stopPropagation();
    });
    
  }
  
  // toggle dropdown on click away
  
  // ???
  
  
}

function copyPostLinkToClipboard() {
  
  var elements = document.getElementsByClassName("copyLinkBtn");
  
  if (elements.length == 0) {
    return console.log("copyPostLinkToClipboard() error: no elements found with class 'copyLinkBtn'");
  }
  
  for (var i = 0; i < elements.length; i++) {
    
    elements.item(i).addEventListener("click", function(e) {
      
      // copy link to clipboard
      let target = e.target || e.srcElement;
      let link = target.getAttribute("data-link");
      console.log(link, "copied to clipboard");
      // creates a temporary input element to store the link to copy to clipboard
      let tempInput = document.createElement("input");
      tempInput.value = link;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
      
      // hide share menu
      target.closest(".wrapper").classList.toggle("hidden");
      
      e.stopPropagation();
      
      // pops a notification up
      var notif= createNotification("success", "lien copié");
      var notifWrapper = document.getElementById("notifWrapper");
      notifWrapper.appendChild(notif);
      
      addRemoveElementsClickListener("closeNotifBtn", "notification");
      setElementTimeout("notification", 4000);
    });
  }
}

function addCardLinksToPosts() {
  
  var posts = document.getElementsByClassName("post");
  
  if (posts.length == 0) {
    return console.log("addCardLinksToPosts() error: no elements found");
  }
  
  var protocol = window.location.protocol;
  var host = window.location.host;
  
  for (var i = 0; i < posts.length; i++) {
    
    let display_name = posts.item(i).getAttribute("data-community");
    let hash = posts.item(i).getAttribute("data-hash");
    let slug = posts.item(i).getAttribute("data-slug");
    let url = protocol + "//" + host + "/k/" + display_name + "/" + hash + "/" + slug;
    
    posts.item(i).addEventListener("click", function() {
      window.location.href=url;
    });
    
  }
}

