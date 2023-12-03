import { postData } from "../Generals/requests.js";

export class listOfUsers {
  constructor(destination) {
    this.destination = destination;
    this.currentPage = 1;
    this.itemsPerPage = 5;
  }

  render(items) {
    this.items = items; // Guardar los elementos para la paginación
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;
    const endIndex = startIndex + this.itemsPerPage;
    const paginatedItems = items.slice(startIndex, endIndex);

    const table = document.createElement("table");
    table.classList.add("table", "table-striped");

    const tableHead = document.createElement("thead");
    tableHead.innerHTML = `
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Tipo de usuario</th>
                <th>Acciones</th>
            </tr>
        `;
    table.appendChild(tableHead);

    const tableBody = document.createElement("tbody");
    paginatedItems.forEach((element) => {
      let users = new Users(
        element.id,
        element.nombre,
        element.correo,
        element.idTipoUsuario
      );
      tableBody.appendChild(users.create());
    });
    table.appendChild(tableBody);

    const paginationContainer = document.createElement("div");
    paginationContainer.classList.add(
      "d-flex",
      "justify-content-center",
      "mt-4"
    );

    const totalPages = Math.ceil(items.length / this.itemsPerPage);
    for (let i = 1; i <= totalPages; i++) {
      const pageLink = document.createElement("button");
      pageLink.classList.add("btn", "btn-secondary", "mx-1");
      pageLink.textContent = i;
      pageLink.addEventListener("click", () => this.changePage(i));
      paginationContainer.appendChild(pageLink);
    }

    const paginationRow = document.createElement("tr");
    const paginationCell = document.createElement("td");
    paginationCell.setAttribute("colspan", "4");
    paginationCell.classList.add("text-center");
    paginationCell.appendChild(paginationContainer);
    paginationRow.appendChild(paginationCell);
    table.appendChild(paginationRow);

    this.destination.innerHTML = ""; // Limpiar contenido previo
    this.destination.appendChild(table);
  }

  changePage(pageNumber) {
    this.currentPage = pageNumber;
    this.render(this.items); // Renderizar con los elementos guardados
  }

  setDestination(dest) {
    this.destination = dest;
  }
}

export class Users {
  constructor(id, nombre, correo, idTipoUsuario) {
    this.id = id;
    this.row = document.createElement("tr");
    this.nameCell = document.createElement("td");
    this.emailCell = document.createElement("td");
    this.type = document.createElement("td");
    this.actionsCell = document.createElement("td");

    this.nameCell.textContent = nombre;
    this.emailCell.textContent = correo;
    this.type.textContent =
      idTipoUsuario === "1"
        ? "Usuario"
        : idTipoUsuario === "2"
        ? "Maestro"
        : "Administrador";

    this.sendEmail = document.createElement("i");
    this.sendEmail.classList.add("fa", "fa-light", "fa-paper-plane");
    this.sendEmail.setAttribute("data-bs-toggle", "tooltip");
    this.sendEmail.setAttribute("title", "Enviar correo");
    this.sendEmail.classList.add("btn", "btn-link");
    this.sendEmail.addEventListener("click", () => sendEmail(id, correo));

    this.changeType = document.createElement("i");
    this.changeType.classList.add("fas", "fa-exchange-alt");
    this.changeType.setAttribute("data-bs-toggle", "tooltip");
    this.changeType.setAttribute(
      "title",
      `Cambiar tipo del usuario a ${
        idTipoUsuario === "1" ? "Maestro" : "Usuario"
      }`
    );
    this.changeType.classList.add("btn", "btn-link");
    this.changeType.addEventListener("click", () =>
      changeType(id, idTipoUsuario)
    );

    if (idTipoUsuario != "3") {
      this.actionsCell.appendChild(this.sendEmail);
      this.actionsCell.appendChild(this.changeType);
    }

    this.row.appendChild(this.nameCell);
    this.row.appendChild(this.emailCell);
    this.row.appendChild(this.type);
    this.row.appendChild(this.actionsCell);
  }

  create() {
    return this.row;
  }

  getNode() {
    return this.row;
  }
}

const sendEmail = async (id, email) => {
  Swal.fire({
    title: "Reinico de contraseña",
    text: "¿Estas seguro de que quieres reiniciar la contraseña para este usuario?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Si estoy seguro",
  }).then((result) => {
    if (result.isConfirmed) {
      const data = new FormData();
      data.append("req", "send_mail");
      data.append("email", email);
      data.append("id", id);
      postData("../../models/admin.php", data).then((resp) => {
        const type = resp.code == "ok" ? "success" : "error";
        Swal.fire({
          icon: type,
          title: resp.message,
        });
      });
    }
  });
};

const changeType = async (id, typeUser) => {
  Swal.fire({
    title: "Cambiar tipo de usuario",
    text: "¿Estas seguro de que quieres cambiar el tipo de este usuario?",
    showDenyButton: true,
    showCancelButton: true,
    confirmButtonText: "Si estoy seguro",
  }).then((result) => {
    if (result.isConfirmed) {
      const data = new FormData();
      data.append("req", "change_type");
      data.append("type", typeUser);
      data.append("id", id);
      postData("../../models/admin.php", data).then((resp) => {
        const type = resp.code == "ok" ? "success" : "error";
        Swal.fire({
          icon: type,
          title: resp.message,
        }).then(() => {
          location.reload();
        });
      });
    }
  });
};
