let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
 if(sidebar.classList.contains("open")){
   closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
 }else {
   closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
 }
}

if(window.matchMedia("(min-width:576px)").matches){
  var carouselWidth = $("#carousel-inner")[0].scrollWidth;
  var cardWidth = $("#carousel-item").width();
  var scrollPosition = 0;
  
  $(".carousel-control-next").on("click", function () {
    if (scrollPosition < (carouselWidth - cardWidth * 4)) { //check if you can go any further
      console.log('next')
      scrollPosition += cardWidth;  //update scroll position
      $("#carousel-inner").animate({ scrollLeft: scrollPosition },600); //scroll left
    }
  });
  $(".carousel-control-prev").on("click", function () {
    if (scrollPosition > 0) {
      console.log('next')
      scrollPosition -= cardWidth;
      $("#carousel-inner").animate(
        { scrollLeft: scrollPosition },
        600
      );
    }
  });
}
