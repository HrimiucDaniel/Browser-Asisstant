// script that has the scope to embed the youtube link we got from the server into the interface
function embedYouTube(youtubeLink) {
// function which embeddeds the video into the "player" div
  var videoId = getVideoIdFromURL(youtubeLink);
  var embeddedVideo = document.getElementById("player");
  var embeddedLink =  '<iframe width="560" height="315" src="https://www.youtube.com/embed/';
  embeddedLink = embeddedLink + videoId;
  console.log(embeddedLink);
  embeddedLink = embeddedLink +  '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>;'
  embeddedVideo.innerHTML = embeddedLink;

}

function getVideoIdFromURL(url) {
  //function which returns the embeded url of the video
  var videoId = "";
  var startIndex = url.indexOf("watch?v=");
  x = url.length - (startIndex + 8);
  videoId = url.substring(url.length - x);
  console.log(url);
  console.log(videoId);
  return videoId;
}
