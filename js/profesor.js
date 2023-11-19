import { isEmpty } from "./Generals/form.js";
import { postData } from "./Generals/requests.js";
import { listOfCourses } from "./Generals/domClasses.js";

const firstReq = new FormData();
firstReq.append('req', 'get_courses');
const grid = document.querySelector('#courses');
postData('../models/courses.php', firstReq)
    .then((resp) => {
        if (resp.data === "ok") {
            let courses = new listOfCourses(grid);
            courses.render(resp.message);
        }
    })
eventListeners();

function eventListeners() {
    document.querySelector("#createCourse").addEventListener("submit", submitForm);
}

function submitForm(e) {
    e.preventDefault();
    const formCreateCourse = document.querySelector("#createCourse");
    const values = new FormData(formCreateCourse);
    values.append('req', 'create');
    if (!isEmpty(values)) {
        postData('../models/courses.php', values).
            then((resp) => {
                const type = resp.data == "ok" ? "success" : "error"
                Swal.fire({
                    icon: type,
                    title: type,
                    text: resp.data
                }).then((result) => {
                    if (result.isConfirmed) {
                    }
                })
            });
    }
}

// function cleanForm() {
//     document.querySelector("#name").value = ""; // Limpiar campos
//     document.querySelector("#email").value = "";
//     document.querySelector("#password").value = "";
// }
