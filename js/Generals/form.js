export function validateEmail(form) {
    const email = form.get('email');
    const password = form.get('password');
    if (email === '' || password === '') return false;
    if (!/^[\w-]+(\.[\w-]+)*@[\w-]+(\.[\w-]+)+$/.test(email)) {
        Swal.fire({
            icon: "error",
            title: "Error!",
            text: `El correo es incorrecto`,
        });
        return false;
    }
    return true;
}

export function isEmpty(form) {
    let emptyValues = false;
    const formDataArray = Array.from(form.entries());

    for (const [key, value] of formDataArray) {

        if (value.trim() === "") {
            emptyValues = true;
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: `El campo ${key} está vacío.`,
            });
        }
    }

    return emptyValues;
}

// export function cleanForm(form) {
//     let emptyValues = false;
//     const formDataArray = Array.from(form.entries());

//     for (const [key, value] of formDataArray) {
//         value = ""
//     }
// }

