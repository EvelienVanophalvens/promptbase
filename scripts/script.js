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
const bio = document.getElementById('bio');

// Voeg een event listener toe aan het p element om een input veld te maken
  bio.addEventListener('click', () => {
  const inputVeld = document.createElement('input');
  inputVeld.setAttribute('type', 'text');
  inputVeld.value = bio.textContent;
  bio.replaceWith(inputVeld);
  
  // Voeg een event listener toe aan het input veld om de wijzigingen op te slaan en het input veld te vervangen door het p element
    inputVeld.addEventListener('keyup', (event) => {
    if (event.key === 'Enter') {
      const newBio = inputVeld.value;
      bio.textContent = newBio;
      inputVeld.replaceWith(bio);
      User.update(newBio);
    }
  });

});
