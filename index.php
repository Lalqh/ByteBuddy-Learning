<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ByteBuddy-Learning</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles/index.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="../ByteBuddy-Learning/index2.html"><img src="../ByteBuddy-Learning/assets/images/Logo ByteBuddy Learning.png" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="views/login.html">Iniciar sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="views/Register.html">Registrarse</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="carritoIcono" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img style="width: 20px; height: 20px;" src="assets/images/carrito-de-compras.png" alt="Carrito">
              <span id="contadorCarrito" class="badge badge-pill badge-danger">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="carritoIcono">
              <div id="carritoProductos" class="dropdown-item">
                <!-- Productos agregados al carrito -->
              </div>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Ir a comprar</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row" id="productos">
      <?php
      require_once __DIR__ . '/models/Database/conector.php';
      require_once __DIR__ . '/models/Database/utils.php';
      $db = DB::getInstance()->getConnection();

      $crud = new Crud($db);

      $result = $crud->select("*", "Cursos", "_status = 'post'");

      if (!$result) {
        echo "No hay productos disponibles";
      } else {
        foreach ($result as $producto) {
      ?>
          <div class="col-md-4 mb-4">
            <div class="card">
              <img src="<?php echo $producto['img_src']; ?>" class="card-img-top" alt="Producto">
              <div class="card-body">
                <h5 class="card-title"><?php echo $producto['nombre']; ?></h5>
                <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                <p class="card-text precio">$<?php echo $producto['precio']; ?></p>
                <button type="button" class="btn btn-primary agregar-carrito" data-id="<?php echo $producto['id']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-descripcion="<?php echo $producto['descripcion']; ?>" data-precio="<?php echo $producto['precio']; ?>" data-imagen="<?php echo $producto['img_src']; ?>">Comprar</button>
              </div>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>

  <footer class="text-black mt-5 footer-custom">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h4>ByteBuddy Learning</h4>
            <p>
              Somos una plataforma global de educación en tecnología,
              comprometida con la excelencia en la enseñanza y la formación de
              profesionales del futuro.
            </p>
          </div>
          <div class="col-md-6">
            <h4>Contacto</h4>
            <p>
              Dirección: C. Nueva Escocia 1885, 44630 Guadalajara, Jalisco
              <br />
              Teléfono: +52 33 1440 8792
              <br />
              Correo Electrónico: soporte@ByteBuddy.mx
            </p>
          </div>
        </div>
      </div>
    </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    let carrito = [];

    const contadorCarrito = document.getElementById('contadorCarrito');
    const carritoProductos = document.getElementById('carritoProductos');

    function agregarAlCarrito(event) {
      event.stopPropagation();
      const idProducto = event.target.getAttribute('data-id');

      const productoExistente = carrito.find(producto => producto.id === idProducto);
      if (productoExistente) {
        return;
      }
    
      const nombreProducto = event.target.getAttribute('data-nombre');
      const descripcionProducto = event.target.getAttribute('data-descripcion');
      const precioProducto = event.target.getAttribute('data-precio');
      const imagenProducto = event.target.getAttribute('data-imagen');

      carrito.push({
        id: idProducto,
        nombre: nombreProducto,
        descripcion: descripcionProducto,
        precio: precioProducto,
        imagen: imagenProducto
      });

      // de puro react xd
      const nuevoProducto = document.createElement('a');
      nuevoProducto.classList.add('dropdown-item');
      nuevoProducto.href = '#';
      nuevoProducto.innerText = nombreProducto;
      carritoProductos.appendChild(nuevoProducto); 

      actualizarContadorCarrito();
    }

    function actualizarContadorCarrito() {
      contadorCarrito.innerText = carrito.length;
    }

    const botonesComprar = document.querySelectorAll('.agregar-carrito');
    botonesComprar.forEach(boton => {
      boton.addEventListener('click', agregarAlCarrito);
    });
  </script>


</body>

</html>