let c = 0;

function Open_Command(result){
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
  chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
    // Get the ID of the current tab
    var currentTabId = tabs[0].id;
    
    // Replace the current tab with another tab
    chrome.tabs.update(currentTabId, {url: url});
  });
}

function addHistory(result)
{
  c = c + 1;
  var x = document.getElementById("history");
  x.style.display = "inline";
  var option = document.createElement("option");

  if (Array.from(x.options).some(option => option.text === result)) {
   
  }else{
    option.text = result;
    x.add(option);
  }
  let y = Math.floor(Math.random() * 100);

  cname = "cookie " + y;
 // chrome.cookies.set({ url: "http://example.com/", name: cname, value: result });

}

function Answer2(){
  const x = document.getElementById("question_bar");
  let result = x.value;
  if (result.startsWith("open")) {
    var tab = document.getElementById("tabs");
    tab.style.display = "inline";
  }

}

function Answer_Question(result, play){
  addHistory(result);
  const data_to_send = {
    query: result
  }
  document.getElementById("answer").innerHTML = "...";
  sendDataToPHP(data_to_send, play);
}

function Answer3(){
  var x = document.getElementById("history").value;
  if (x.startsWith("open")) {
  Open_Command(x);
  }else if (x.startsWith("play")){
    Answer_Question(x, 1);
  }else{
    Answer_Question(x, 0);  
  }

}

function Answer(){
 
  const x = document.getElementById("question_bar");
  let result = x.value;
  if (result.startsWith("open")) {
     Open_Command(result);
  }else if (result.startsWith("play")){
    Answer_Question(result, 1);
  }else{
    Answer_Question(result, 0);  
  }
}


//usage:

var sendButton = document.getElementById("send");


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