<?php
function verifyPlay($string){
  if (strpos($string, "play") === 0) {
    return true;
} else {
    return false;
}
}
?>