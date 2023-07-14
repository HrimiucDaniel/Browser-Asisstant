
function sendDataToPHP(data, play, read) {
/*
- function which manages the comunication with the php server

param:
1. data - the data which needs to be sent to the server
2. play - bool value which specifies that we are in a play command - we need this to embed the returned video in the extension
3. read - bool value which specifies if the answer has to be read aloud
*/

  fetch('http://localhost/Licenta%20-%20Virtual%20Assistance%20Extension/Licenta---Asistentul-Virtual/Formular/Php/get_data.php', {
    //Using the fetch API POST method to send the data to the server
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(data)
})
  .then(response => response.text())
  .then(responseData => {
    // We print in the interface the answer we got from the server
    if (play == 1) {
      const player = document.getElementById("player");
      player.style.display = "inline";
     // we embed the video if we are in a play command
      embedYouTube(responseData); // embed the link into the user interface
    }else{
    document.getElementById("answer").innerHTML = responseData;// The Answer label becoms the answer that the server sent back
    if (read == 1) chrome.tts.speak(responseData);//read the answer out loud
    }
  })
  .catch(error => {
    // Handle any errors
    console.error(error);
  });
}

