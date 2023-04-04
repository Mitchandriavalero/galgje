var text = "GAME OVER... Please wait for a new game",
    soFar = "";

var visible = document.querySelector(".visible"),
    invisible = document.querySelector(".invisible");

invisible.innerHTML = text;
var t = setInterval(function(){
  soFar += text.substr(0, 1),
  text = text.substr(1);

  visible.innerHTML = soFar;
  invisible.innerHTML = text;

  if (text.length === 0) clearInterval(t);
}, 100)