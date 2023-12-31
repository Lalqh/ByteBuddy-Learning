import { postData } from "./Generals/requests.js";
import { listOfCourses } from "./Generals/domClasses.js";
import { checkTypeUser, closeSession } from "./Generals/authManger.js";
import { restedPassoword } from "./Generals/functions.js";
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");

closeBtn.addEventListener("click", () => {
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

// searchBtn.addEventListener("click", () => { // Sidebar open when you click on the search iocn
//   sidebar.classList.toggle("open");
//   menuBtnChange(); //calling the function(optional)
// });

// following are the code to change sidebar button(optional)
function menuBtnChange() {
  if (sidebar.classList.contains("open")) {
    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
  } else {
    closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");//replacing the iocns class
  }
}




checkTypeUser();

const closeSessionLink = document.getElementById('sesion');
closeSessionLink.addEventListener('click', closeSession);

const restPassword = document.getElementById('pas');
restPassword.addEventListener('click', restedPassoword);

const firstReq = new FormData();
firstReq.append('req', 'get_courses');
const grid = document.querySelector('#grid-courses');
const myCourses = document.querySelector('#curseUser');
postData('../../models/courses.php', firstReq)
  .then((resp) => {
    if (resp.code === "ok") {
      let gridCourses = new listOfCourses(grid);

      gridCourses.renderInUsers(resp.data);

    }
  })
const myReqCourses = new FormData();
myReqCourses.append('req', 'my_courses');
postData('../../models/courses.php', myReqCourses)
  .then((resp) => {
    if (resp.code === "ok") {
      let myCoursesGrid = new listOfCourses(myCourses);
      myCoursesGrid.renderMyCourses(resp.data);
    }
  })