function embedYouTube(youtubeLink) {
  var videoId = getVideoIdFromURL(youtubeLink);
  var embeddedVideo = document.getElementById("embeddedVideo");
  
  embeddedVideo.innerHTML = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
}

// Extract the video ID from the YouTube URL
function getVideoIdFromURL(url) {
  var videoId = "";
  var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|v=|\?v=)([^#&?]*).*/;
  var match = url.match(regExp);
  if (match && match[2].length === 11) {
    videoId = match[2];
  } else {
    console.error("Invalid YouTube URL");
  }
  return videoId;
}
