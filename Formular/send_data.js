// Content script or background script in your Chrome extension
function sendDataToPHP(data, play) {
  //document.write("started");

  fetch('http://localhost/Licenta%20-%20Virtual%20Assistance%20Extension/Licenta---Asistentul-Virtual/Formular/Php/get_data.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(data)
})
  .then(response => response.text())
  .then(responseData => {
    // Handle the response from PHP
    //console.log(responseData);
    if (play == 1) {
      document.getElementById("answer").innerHTML = responseData;
      embedYouTube(responseData);
    }else{
    document.getElementById("answer").innerHTML = responseData;
    }
  })
  .catch(error => {
    // Handle any errors
    console.error(error);
  });
}

// const data_to_send = {
//   query: "result"
// }
// sendDataToPHP(data_to_send);

