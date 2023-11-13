import { isEmpty, validateEmail } from "./Generals/form.js";
import { postData } from "./Generals/requests.js";

eventListeners();

function eventListeners() {
    document.querySelector("#createCourse").addEventListener("submit", submitForm);
}

function submitForm(e) {
    e.preventDefault();
    const formCreateCourse = document.querySelector("#createCourse");
    const values = new FormData(formCreateCourse);
    values.append('req', 'create');
    //console.log(values.entries());
    // let aux = Array.from(values.entries());
    // aux.forEach(element => {
    //     console.log(element);
    // })
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
                        //cleanForm();
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
