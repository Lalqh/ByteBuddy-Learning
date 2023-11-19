export function convertToInput(element) {
    // Crea un nuevo elemento de entrada
    let input = document.createElement("input");
    let currentElement = document.createElement(element.tagName);
    // Establece el valor del input como el contenido actual del párrafo
    input.value = element.innerText;


    // Asigna al input el mismo id que el párrafo para facilitar la identificación
    input.id = element.id;

    // Reemplaza el párrafo con el input
    element.parentNode.replaceChild(input, element);

    // Enfoca el input para que el usuario pueda editar inmediatamente
    input.focus();

    // Agrega un evento de pérdida de foco (blur) al input para manejar la finalización de la edición
    input.addEventListener("blur", function () {
        // Reemplaza el input con un nuevo párrafo que tiene el texto actualizado

        var nuevoParrafo = document.createElement("p");
        nuevoParrafo.innerText = input.value;
        nuevoParrafo.id = input.id;
        input.parentNode.replaceChild(nuevoParrafo, input);
    });

}