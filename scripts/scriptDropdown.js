console.log("script.js loaded");
let checkList = document.querySelector('#list1');
console.log(checkList);
document.querySelector('.anchor').addEventListener("click", () =>{
  console.log("clicked");
  if (checkList.classList.contains('visible')){
    checkList.classList.remove('visible');
  }
  else{
    checkList.classList.add('visible');
  }
});