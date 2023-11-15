export const postData = (url, data) => {
  return new Promise((resolve, reject) => {
    /*
        agregar la validacion de token y que tenga uno para poder hacer peticiones
      */

    fetch(url, {
      method: "POST",
      body: data,
    })
      .then(async (response) => {
        const { message, data } = await response.json();
        // console.log(response.text());
        if (response.status === 200) {
          resolve({ message, data });
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
          text: `Ocurrio un error${error}`,
        });
        reject(error);
      });
  });
};
