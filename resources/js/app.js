import './bootstrap';
import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

let body = document.querySelector("body")
let profilePic = document.querySelector(".avatar")
let fullPage = document.querySelector("#fullscreen")
let fermer = document.querySelector("#fullscreen button")
profilePic.addEventListener('click', function() {
    fullPage.style.backgroundImage = 'url(' + profilePic.src + ')'
    fullPage.style.display = 'block'
    body.style.maxHeight = "100vh"
    body.style.overflowY = "hidden"
})

  
if(fermer != null)
fermer.addEventListener("click", function(){
    fullPage.style.display = "none"
    body.style.maxHeight = "none"
    body.style.overflowY = "scroll"
})