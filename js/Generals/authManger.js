
// funcion para el login
export const reditect = (typeUser) => {
  switch (typeUser) {
    case 1:
      window.location.href = "./views/Usuario/index.html";
      break;
    case 2:
      window.location.href = "./Maestro/index.html";
      break;
    case 3:
      window.location.href = "../views/Admin/index.html";
      break;
  }
};

export const saveData = (jwt, typeUser) => {
  localStorage.setItem("JWT", jwt);
  localStorage.setItem("type", typeUser);
  console.log(jwt)
};

export const checkTypeUser = () => {
  const pageTitle = document.title;
  const typeUser = getType();

  if (pageTitle === "Usuarios" && typeUser != 1) {
    reditectTo(typeUser);
  }

  if (pageTitle === "Profesor" && typeUser != 2) {
    reditectTo(typeUser);
  }

  if (pageTitle === "Administrador" && typeUser != 3) {
    reditectTo(typeUser);
  }
}

const getType = () => parseInt(localStorage.getItem("type"));

// funcion para comprobar por pagina
const reditectTo = (typeUser) => {
  switch (typeUser) {
    case 1:
      window.location.href = "../Usuario/index.html";
      break;
    case 2:
      window.location.href = "../Maestro/index.html";
      break;
    case 3:
      window.location.href = "../Admin/index.html";
      break;
  }
}
