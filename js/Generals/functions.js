import { postData } from "./requests.js";

export function convertToInput(element) {
    // Crea un nuevo elemento de entrada
    if (element.getAttribute('is_view_user') != 1) {
        let input = document.createElement("input");
        let copyNode = element.cloneNode(true);
        // Establece el valor del input como el contenido actual del párrafo
        input.value = element.innerText;
        // Asigna al input el mismo id que el párrafo para facilitar la identificación
        input.id = element.id;
        input.classList.add('form-control');

        // Reemplaza el párrafo con el input
        element.parentNode.replaceChild(input, element);

        // Enfoca el input para que el usuario pueda editar inmediatamente
        input.focus();

        // Agrega un evento de pérdida de foco (blur) al input para manejar la finalización de la edición
        input.addEventListener("keyup", function (event) {
            // Reemplaza el input con un nuevo párrafo que tiene el texto actualizado
            if (event.key === 'Enter') {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esta acción!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, guardar cambios!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        copyNode.innerHTML = input.value;
                        let editData = new FormData();
                        editData.append('req', 'edit_course');
                        editData.append('column', element.getAttribute('column'));
                        editData.append('value', input.value);
                        editData.append('id', element.getAttribute('course_id'));

                        postData('../../models/courses.php', editData)
                            .then((resp) => {
                                if (resp.code === "ok") {
                                    Swal.fire(
                                        'Guardado!',
                                        'Tu cambio ha sido guardado.',
                                        'success'
                                    )
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: resp.message,
                                        icon: 'error',
                                        customClass: 'swal-wide',
                                    })
                                }
                            })
                        input.parentNode.replaceChild(copyNode, input);

                    } else {
                        copyNode.innerHTML = input.defaultValue;
                        Swal.fire(
                            'Cancelado!',
                            'Tu cambio no se ha guardado.',
                            'error'
                        )
                    }
                })

            }

        });
    }

}