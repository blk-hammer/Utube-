// function toggle(id1,id2) {
//     var m = document.getElementById(id1);
//     var s = document.getElementById(id2);
//     if(s.style.display == 'block')
//        s.style.display = 'none';
//     else
//        s.style.display = 'block';
//  }

// document.getElementById("sideNavButton").addEventListener("click", function() {
//    alert("Hello World!");
// });
 
$(document).ready(function(){
   $("#sideNavButton").click(function(){
     var main=$("#mainSectionContainer");
     var nav=$("#sideNavContainer");
     if(main.hasClass("leftPadding")){
        nav.hide();
     }
     else{
        nav.show();
     }
     main.toggleClass("leftPadding");
   });
 });

 function notSignedIn() {
   alert("You must be signed in to perform this action");
}