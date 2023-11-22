import { isEmpty } from "./Generals/form.js";
import { postData, validateToken } from "./Generals/requests.js";
import { Course, listOfCourses } from "./Generals/domClasses.js";


const firstReq = new FormData();
firstReq.append('req', 'get_courses');
const grid = document.querySelector('#courses');
postData('../../models/courses.php', firstReq)
    .then((resp) => {
        if (resp.code === "ok") {
            let courses = new listOfCourses(grid);
            console.log(resp.message)
            courses.render(resp.data);
        }
    })
eventListeners();

function eventListeners() {
    // document.addEventListener('DOMContentLoaded', function () {
    //     validateToken('../../models/Auth/jwtManager.php')
    //         .then((resp) => {
    //             if (resp.code === "ok") {
    //                 console.log(resp.message)
    //             }
    //         })
    // })
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
                const type = resp.code == "ok" ? "success" : "error"
                let currentId = Array.from(resp.data);
                Swal.fire({
                    icon: type,
                    title: type,
                    text: 'Guardado con éxito'

                }).then((result) => {
                    if (result.isConfirmed) {
                        let newCourse = new Course(
                            currentId[0]["id"],
                            values.get('nombreCurso'),
                            values.get('descripcionCurso'),
                            values.get('precioCurso'));
                        grid.appendChild(newCourse.create());
                    }
                })
            });
    }
}

