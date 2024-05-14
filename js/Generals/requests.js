export const postData = (url, data) => {
  const token = localStorage.getItem("JWT");
  return new Promise((resolve, reject) => {
    /*
        agregar la validacion de token y que tenga uno para poder hacer peticiones
      */

    fetch(url, {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token}`,
      },
      body: data,
    })
      .then(async (response) => {
        console.log("respuesta", response)
        const { code, message, data } = await response.json();
        console.log(response.text());
        if (response.status === 200) {
          resolve({ code, message, data });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error!",
            text: `Ocurrio un error${response.status}`,
          });
          reject(`Error: ${response.status}`);
        }
      })
      .catch((error) => {
        Swal.fire({
          icon: "error",
          title: "Error!",
          text: `Ocurrio un error`,
        });
        reject(error);
      });
  });
};
