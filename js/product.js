import { postData } from "./Generals/requests.js";
const currentURL = window.location.href;
const urlSearchParams = new URLSearchParams(new URL(currentURL).search);
let data = new FormData();
data.append('course_id', urlSearchParams.get('curso_id'));
data.append('req', 'get_course')

postData('../../models/courses.php', data)
    .then((resp) => {
        if (resp.code === "ok") {
            if (resp.data.length === 0) {
                Swal.fire(
                    'No se encontraron resultados!',
                    ``,
                    'error',
                    setTimeout(() => {
                        window.location.href = './index.html'
                    }, 2000)
                )
            }
            console.log(resp.message)
        } else {
            Swal.fire(
                'Error!',
                resp.message,
                'error'
            )
        }
    })