/*
Logica para el inicio de sesion.

El usuario debe ser redireccionado a su vista correspondiente
segun su tipo:

1- Estudiante => Vista estudiante
2- Profesior => Vista profesor
3- Administrador => Vista administrador
*/

import { isEmpty, validateEmail } from "./Generals/form.js";
import { postData } from "./Generals/requests.js";

eventListeners();

function eventListeners() {
  document.querySelector("#login").addEventListener("submit", validateData);
}

function validateData(e) {
  //Evitar que haga la accion
  e.preventDefault();
  const from = document.querySelector("#login");
  const values = new FormData(from);

  if (!isEmpty(values)) {
    if (validateEmail(values)) {
      postData("../models/login.php", values).then((resp) => {
        console.log(resp);
        const type = resp.code == "ok" ? "success" : "error";
        Swal.fire({
          icon: type,
          title: type,
          text: resp.message,
        }).then((result) => {
          if (result.isConfirmed) {
            if (resp.code == "ok") {
              saveJwt(resp.data.token);
              const typeUser = parseInt(resp.data.typeUser);
              switch (typeUser) {
                case 1:
                  window.location.href = "./Usuario/index.html";
                  break;
                case 2:
                  window.location.href = "./Maestro/index.html";
                  break;
                case 3:
                  window.location.href = "./Admin/index.html";
                  break;
              }
            } else {
              cleanForm();
            }
          }
        });
      });
    }
  }
}

function cleanForm() {
  document.querySelector("#email").value = "";
  document.querySelector("#password").value = "";
}

function saveJwt(jwt) {
  localStorage.setItem("JWT", jwt);
}