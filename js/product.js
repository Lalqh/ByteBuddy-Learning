import { postData } from "./Generals/requests.js";
const currentURL = window.location.href;
const urlSearchParams = new URLSearchParams(new URL(currentURL).search);
let data = new FormData();
data.append('course_id', urlSearchParams.get('curso_id'));
data.append('req', 'get_course');
let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let img = document.querySelector("#img_course");
let price = document.querySelector("#product_price");
let title = document.querySelector("#product_title");
let description = document.querySelector("#product_description");
closeBtn.addEventListener("click", () => {
    sidebar.classList.toggle("open");
    menuBtnChange();//calling the function(optional)
});

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
            } else {
                img.src = resp.data[0].img_src;
                title.innerHTML = resp.data[0].nombre;
                price.innerHTML = "Precio : $" + resp.data[0].precio;
                description.innerHTML = "Descripcion: " + resp.data[0].descripcion;
                fillStars(resp.data[0].estrellasCurso)
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
function fillStars(cal) {
    // Obtener el contenedor de calificación
    const ratingContainer = document.getElementById("ratingContainer");

    // Redondear la calificación al número entero más cercano
    const calificacionRedondeada = Math.round(cal);

    // Llenar las estrellas
    for (let i = 0; i < 5; i++) {
        const star = document.createElement("span");
        star.className = "rating-star" + (i < calificacionRedondeada ? "" : "-empty");
        star.innerHTML = "&#9733;";
        ratingContainer.appendChild(star);
    }
}