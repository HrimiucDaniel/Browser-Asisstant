// script that manages the basic functionalities of the extension
let c = 0;

function Open_Command(result){
  //function which manages the OPEN COMMAND
  addHistory(result);
  document.getElementById("question_bar").value = result;

  let server_name = result.replace("open ", "");
  let text1 = "https://www.";
  let text2 = text1.concat(server_name);
  let url = text2.concat('.com');
  
  var tab = document.getElementById("tabs").value;
  if (tab == "New Tab") {
    window.open(url, '_blank');
  }else{
    ChromeTabs(url);
  }



  document.getElementById("answer").innerHTML = "Trying to open ".concat(url);

}




function ChromeTabs(url) {
  //Replace the current Tab

  chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {

    // Get the ID of the current tab
    var currentTabId = tabs[0].id;
    
    // Replace the current tab with another tab
    chrome.tabs.update(currentTabId, {url: url});
  });
}

function setCookie(name, result){
// Function to set cookies having the name and the result
  var expirationTime = Date.now() + (7 * 24 * 60 * 60 * 1000); // Expiration time set to 7 days from now(can be changed with any value)

  var cookie = {
    url: 'https://example.com',
    name: name,
    value: result,
    expirationDate: expirationTime / 1000  
  };

  chrome.cookies.set(cookie, function(cookie) {
    console.log('Cookie set:', cookie);
  });
}

function addHistory(string) {
  // function to add a string to the history select box
  var selectBox = document.getElementById("history");
  var options = selectBox.options;

  // Check if the string already exists in the select box
  for (var i = 0; i < options.length; i++) {
    if (options[i].text === string) {
      return; // String already exists, exit the function
    }
  }

  // String doesn't exist, add it as a new option
  var newOption = document.createElement("option");
  newOption.text = string;
  selectBox.add(newOption);
  let y = Math.floor(Math.random() * 100);

  cname = "cookie " + y;
  setCookie(cname, string);
}



function Answer2(){
  // function to verify if the user starts a command with the open keyword(before sending the command)
  const x = document.getElementById("question_bar");
  let result = x.value;

  if (result.startsWith("open")) {
    var tab = document.getElementById("tabs");
    tab.style.display = "inline";
  }else{
    const tabs = document.getElementById("tabs");
    tabs.style.display = "none";
  }

}

function Answer_Question(result, play){
  //function to send the query to the server

  addHistory(result); // add the command in the history dropdown select menu

  const data_to_send = { // creating the json structure which needs to be sent to the server
    query: result
  }

  document.getElementById("answer").innerHTML = "..."; //The answer label becomes "..." to show that we started processing the command

  const checkbox = document.getElementById('check_read'); //we verify the read out loud checkbox

  if (checkbox.checked) {
    sendDataToPHP(data_to_send, play, 1); // we call the function which sends the data to PHP
  }else{
    sendDataToPHP(data_to_send, play, 0); // we call the function which sends the data to PHP
  }

}

function Answer3(){
  // function that executes when an element is chosen from the select box
  // copies the functionalities of the normal Answer function

  const player = document.getElementById("player");
  player.style.display = "none";
  var x = document.getElementById("history").value;
  var q = document.getElementById("question_bar");
  q.value = x;

  if (x.startsWith("open")) {
    Open_Command(x);
  }else if (x.startsWith("play")){
    Answer_Question(x, 1);
  }else{
    Answer_Question(x, 0);  
  }

}

function Answer(){
  // function that executes when the user sends a command
  // we manage which function we needs to be executen keeping the keywords in mind

  const player = document.getElementById("player"); 
  player.style.display = "none";
  const x = document.getElementById("question_bar"); //input box from the extension
  let result = x.value;
  if (result.startsWith("open")) {
     Open_Command(result);
  }else if (result.startsWith("play")){
    Answer_Question(result, 1); //play = true
  }else{
    Answer_Question(result, 0); //play = false
  }
}



var sendButton = document.getElementById("send");

// Event listeners

sendButton.addEventListener("click", function() {
  Answer();
});

document.getElementById("question_bar").addEventListener("keydown", function(e) {
  if (e.key === 'Enter') {
    Answer();
  } 
});
document.getElementById("question_bar").addEventListener("input", Answer2);
document.getElementById("history").addEventListener("change", Answer3);


window.addEventListener("load", (event) => {
  chrome.cookies.getAll({}, function(cookies) {
    for (var i = 0; i < cookies.length; i++) {
      var x = document.getElementById("history");
      x.style.display = "inline";
      var option = document.createElement("option");
      if (cookies[i].name.startsWith("cookie ")){
      option.text = cookies[i].value;
      x.add(option);
      }
    }
  });

});

window.addEventListener('blur', function(event) {
  window.focus();
});
const player = document.getElementById("player");
player.style.display = "none";
const tabs = document.getElementById("tabs");
tabs.style.display = "none";
const checkbox = document.getElementById('check_read');
checkbox.addEventListener('change', (event) => {

  if (checkbox.checked) {
    const text = document.getElementById("answer").innerHTML;
    chrome.tts.speak(text);
  }else{
    chrome.tts.stop();
  }
});
window.addEventListener('beforeunload', function(event) {
  // Stop TTS speech when the popup is closed
  chrome.tts.stop();
});

