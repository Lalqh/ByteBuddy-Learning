eventListeners();

function eventListeners() {
  document.querySelector("#from").addEventListener("submit", validateData);
}

function validateData(e) {
  //Evitar que haga la accion
  e.preventDefault();

  //Obetner valores
  const name = document.querySelector("#name").value,
    email = document.querySelector("#email").value,
    password = document.querySelector("#password").value;

  //Si un dato no se ingreso
  if (name === "" || email === "" || password === "") {
    Swal.fire({
      icon: "error",
      title: "Error!",
      text: "¡Debes de llenar todos los campos!",
    });
  } else {

    const dataUser = new FormData();
    dataUser.append("name", name);
    dataUser.append("email", email);
    dataUser.append("password", password);

    $.ajax({
      url: "../models/register.php",
      type: "POST",
      data: dataUser,
      processData: false,
      contentType: false,
      success: function (data) {
        const jsonData = JSON.parse(data);
        if (jsonData.respuesta === "correcto") {
          // El usuario se registró correctamente
          Swal.fire({
            title: "Usuario creado",
            text: "El usuario se registró correctamente",
            icon: "success",
          }).then((result) => {
            if (result.value) {
              window.location.href = "../views/login.html";
            }
          });
        }
        // Si el usuario ya existe
        else if (jsonData.respuesta === "registrado") {
          Swal.fire({
            title: "Este usuario ya existe",
            text: "El usuario ya existe, inicie sesión con su usuario y contraseña",
            icon: "error",
          }).then((result) => {
            if (result.value) {
              cleanFrom();
              window.location.href = "../views/login.html";
            }
          });
        }
      },
    });
  }
}

function cleanFrom() {
  document.querySelector("#name").value = ""; // Limpiar campos
  document.querySelector("#email").value = "";
  document.querySelector("#password").value = "";
}