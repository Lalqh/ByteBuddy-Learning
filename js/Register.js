import { isEmpty, validateEmail } from "./Generals/form.js";
import { postData } from "./Generals/requests.js";

eventListeners();

function eventListeners() {
  document.querySelector("#from").addEventListener("submit", validateData);
}

function validateData(e) {
  //Evitar que haga la accion
  e.preventDefault();
  const from = document.querySelector("#from");
  const values = new FormData(from);

  if (!isEmpty(values)) {
    if (validateEmail(values)) {
      postData('../models/register.php', values).
        then((resp) => {
          const type = resp == "ok" ? "success" : "error"
          Swal.fire({
            icon: type,
            title: type,
            text: resp.data
          }).then((result) => {
            if (result.isConfirmed) {
              cleanFrom();
            }
          })
        });
    }
  }
}

function cleanFrom() {
  document.querySelector("#name").value = ""; // Limpiar campos
  document.querySelector("#email").value = "";
  document.querySelector("#password").value = "";
}
