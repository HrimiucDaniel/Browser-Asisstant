const recognition = new SpeechRecognition();
recognition.lang = 'en-US';
recognition.continuous = true;
recognition.onstart = function() {
  console.log('Speech recognition started.');
};

recognition.onresult = function(event) {
  const transcript = event.results[event.results.length - 1][0].transcript;
  console.log('Recognized speech: ' + transcript);
};

recognition.onerror = function(event) {
  console.error('Speech recognition error: ' + event.error);
};
recognition.start();
