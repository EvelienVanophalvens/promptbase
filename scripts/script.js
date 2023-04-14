let active = false;
console.log("script.js loaded");
document.querySelector("#userProfilePicture img").addEventListener("click", function() {
    document.querySelector("#profilePictureMenu").classList.remove("hidden");
});

document.querySelector("#changePicture").addEventListener("click", function() {
    if(active === false){
        document.querySelector(".context").classList.add("faded");
        document.querySelector("#profilePictureForm").classList.remove("hidden");
        document.querySelector("#profilePictureForm").style.transform = "translate(-50%, -50%)";
        active = true;
    }
});

document.querySelector("#cancelPicture").addEventListener("click", function() {
    document.querySelector(".context").classList.remove("faded");
    document.querySelector("#profilePictureForm").classList.add("hidden");
});

document.addEventListener("click", function(e) {
    console.log("hello");
    if(e.target !== document.querySelector("#changePicture") && e.target !== document.querySelector("#userProfilePicture img")){
        document.querySelector("#profilePictureMenu").classList.add("hidden");
    }
});